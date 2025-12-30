<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'Contenido';

    protected static ?string $modelLabel = 'Evento';

    protected static ?string $pluralModelLabel = 'Eventos';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del Evento')
                    ->schema([
                        Forms\Components\TextInput::make('titulo')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Forms\Set $set, ?string $state) =>
                                $set('slug', Str::slug($state))
                            ),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Forms\Components\Select::make('categoria')
                            ->options(Event::CATEGORIAS)
                            ->required()
                            ->native(false)
                            ->default('general'),

                        Forms\Components\Textarea::make('descripcion_corta')
                            ->label('Descripción corta')
                            ->rows(2)
                            ->maxLength(500)
                            ->helperText('Resumen breve para listados (máx. 500 caracteres)'),

                        Forms\Components\RichEditor::make('descripcion')
                            ->label('Descripción completa')
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('imagen')
                            ->image()
                            ->directory('eventos')
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('1200')
                            ->imageResizeTargetHeight('675'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Fecha y Hora')
                    ->schema([
                        Forms\Components\DatePicker::make('fecha_inicio')
                            ->label('Fecha de inicio')
                            ->required()
                            ->native(false)
                            ->displayFormat('d/m/Y'),

                        Forms\Components\DatePicker::make('fecha_fin')
                            ->label('Fecha de fin')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->helperText('Dejar vacío si es un evento de un solo día'),

                        Forms\Components\TimePicker::make('hora_inicio')
                            ->label('Hora de inicio')
                            ->seconds(false),

                        Forms\Components\TimePicker::make('hora_fin')
                            ->label('Hora de fin')
                            ->seconds(false),
                    ])
                    ->columns(4),

                Forms\Components\Section::make('Ubicación')
                    ->schema([
                        Forms\Components\TextInput::make('lugar')
                            ->maxLength(255)
                            ->helperText('Ej: Templo Principal, Salón Parroquial'),

                        Forms\Components\Textarea::make('direccion')
                            ->label('Dirección completa')
                            ->rows(2)
                            ->helperText('Dirección física del evento'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Configuración')
                    ->schema([
                        Forms\Components\Toggle::make('es_destacado')
                            ->label('Evento destacado')
                            ->helperText('Los eventos destacados aparecen en la página de inicio'),

                        Forms\Components\Toggle::make('activo')
                            ->label('Evento activo')
                            ->default(true)
                            ->helperText('Los eventos inactivos no se muestran en el sitio público'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('imagen')
                    ->circular()
                    ->defaultImageUrl(fn () => 'https://ui-avatars.com/api/?name=E&background=6366f1&color=fff'),

                Tables\Columns\TextColumn::make('titulo')
                    ->searchable()
                    ->sortable()
                    ->limit(40),

                Tables\Columns\TextColumn::make('fecha_inicio')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('hora_inicio')
                    ->label('Hora')
                    ->time('H:i')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('categoria')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => Event::CATEGORIAS[$state] ?? $state)
                    ->color(fn (string $state): string => match ($state) {
                        'liturgico' => 'primary',
                        'social' => 'success',
                        'formacion' => 'warning',
                        'comunitario' => 'info',
                        default => 'gray',
                    }),

                Tables\Columns\IconColumn::make('es_destacado')
                    ->label('Destacado')
                    ->boolean()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('activo')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('activo')
                    ->label('Estado')
                    ->placeholder('Todos')
                    ->trueLabel('Activos')
                    ->falseLabel('Inactivos'),

                Tables\Filters\SelectFilter::make('categoria')
                    ->options(Event::CATEGORIAS),

                Tables\Filters\TernaryFilter::make('es_destacado')
                    ->label('Destacado')
                    ->placeholder('Todos')
                    ->trueLabel('Destacados')
                    ->falseLabel('No destacados'),

                Tables\Filters\Filter::make('proximos')
                    ->label('Solo próximos eventos')
                    ->query(fn ($query) => $query->where('fecha_inicio', '>=', now()->startOfDay())),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('fecha_inicio', 'desc');
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
