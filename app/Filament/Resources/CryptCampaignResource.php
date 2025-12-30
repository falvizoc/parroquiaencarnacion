<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CryptCampaignResource\Pages;
use App\Models\CryptCampaign;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CryptCampaignResource extends Resource
{
    protected static ?string $model = CryptCampaign::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $navigationGroup = 'Servicios';

    protected static ?string $navigationLabel = 'Campañas de Criptas';

    protected static ?string $modelLabel = 'Campaña';

    protected static ?string $pluralModelLabel = 'Campañas de Criptas';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información de la Campaña')
                    ->schema([
                        Forms\Components\TextInput::make('titulo')
                            ->label('Título')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Ej: Campaña de Mantenimiento Anual 2025'),

                        Forms\Components\Textarea::make('descripcion')
                            ->label('Descripción')
                            ->required()
                            ->rows(4)
                            ->placeholder('Describe los beneficios o detalles de la campaña...')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Período de Vigencia')
                    ->schema([
                        Forms\Components\DatePicker::make('fecha_inicio')
                            ->label('Fecha de Inicio')
                            ->required()
                            ->native(false)
                            ->displayFormat('d/m/Y'),

                        Forms\Components\DatePicker::make('fecha_fin')
                            ->label('Fecha de Fin')
                            ->required()
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->afterOrEqual('fecha_inicio'),

                        Forms\Components\Toggle::make('activo')
                            ->label('Campaña Activa')
                            ->default(true)
                            ->helperText('El banner solo aparece si la campaña está activa y dentro del período de vigencia'),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Apariencia del Banner')
                    ->schema([
                        Forms\Components\FileUpload::make('imagen_banner')
                            ->label('Imagen del Banner (opcional)')
                            ->image()
                            ->directory('criptas/campanas')
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('3:1')
                            ->imageResizeTargetWidth('1200')
                            ->imageResizeTargetHeight('400')
                            ->helperText('Si no se sube imagen, se usará el color de fondo'),

                        Forms\Components\ColorPicker::make('color_fondo')
                            ->label('Color de Fondo')
                            ->default('#f59e0b')
                            ->helperText('Se usa si no hay imagen de banner'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Botón de Acción (opcional)')
                    ->schema([
                        Forms\Components\TextInput::make('texto_boton')
                            ->label('Texto del Botón')
                            ->maxLength(50)
                            ->placeholder('Ej: Más información'),

                        Forms\Components\TextInput::make('url_boton')
                            ->label('URL del Botón')
                            ->url()
                            ->placeholder('https://...')
                            ->helperText('Puede ser un enlace externo o interno'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('titulo')
                    ->label('Campaña')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('fecha_inicio')
                    ->label('Inicio')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('fecha_fin')
                    ->label('Fin')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('dias_restantes')
                    ->label('Estado')
                    ->formatStateUsing(function ($state, $record) {
                        if (!$record->activo) {
                            return 'Inactiva';
                        }
                        if ($record->esta_vigente) {
                            return $state > 0 ? "{$state} días restantes" : 'Último día';
                        }
                        if ($record->fecha_inicio > now()) {
                            return 'Próximamente';
                        }
                        return 'Finalizada';
                    })
                    ->badge()
                    ->color(function ($record) {
                        if (!$record->activo) return 'gray';
                        if ($record->esta_vigente) return 'success';
                        if ($record->fecha_inicio > now()) return 'warning';
                        return 'danger';
                    }),

                Tables\Columns\IconColumn::make('activo')
                    ->label('Activa')
                    ->boolean(),

                Tables\Columns\ColorColumn::make('color_fondo')
                    ->label('Color'),
            ])
            ->defaultSort('fecha_inicio', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('activo')
                    ->label('Estado')
                    ->placeholder('Todas')
                    ->trueLabel('Solo activas')
                    ->falseLabel('Solo inactivas'),
            ])
            ->actions([
                Tables\Actions\Action::make('duplicar')
                    ->label('Duplicar')
                    ->icon('heroicon-o-document-duplicate')
                    ->color('gray')
                    ->action(function (CryptCampaign $record) {
                        $nuevo = $record->replicate();
                        $nuevo->titulo = $record->titulo . ' (copia)';
                        $nuevo->fecha_inicio = now()->startOfMonth()->addMonth();
                        $nuevo->fecha_fin = now()->startOfMonth()->addMonth()->endOfMonth();
                        $nuevo->activo = false;
                        $nuevo->save();
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCryptCampaigns::route('/'),
            'create' => Pages\CreateCryptCampaign::route('/create'),
            'edit' => Pages\EditCryptCampaign::route('/{record}/edit'),
        ];
    }
}
