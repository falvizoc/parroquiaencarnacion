<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChapelResource\Pages;
use App\Jobs\TranslateContentJob;
use App\Models\Chapel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ChapelResource extends Resource
{
    use Translatable;
    protected static ?string $model = Chapel::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';

    protected static ?string $navigationGroup = 'Parroquia';

    protected static ?string $modelLabel = 'Capilla';

    protected static ?string $pluralModelLabel = 'Capillas';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información General')
                    ->schema([
                        Forms\Components\TextInput::make('nombre')
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

                        Forms\Components\Textarea::make('descripcion')
                            ->label('Descripción')
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('imagen')
                            ->image()
                            ->directory('capillas')
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('1200')
                            ->imageResizeTargetHeight('675'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Ubicación y Contacto')
                    ->schema([
                        Forms\Components\TextInput::make('direccion')
                            ->label('Dirección')
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('telefono')
                            ->label('Teléfono')
                            ->tel()
                            ->maxLength(20),

                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('mapa_url')
                            ->label('URL de Google Maps')
                            ->url()
                            ->maxLength(500)
                            ->helperText('URL de embed de Google Maps')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('latitud')
                            ->numeric()
                            ->step(0.00000001),

                        Forms\Components\TextInput::make('longitud')
                            ->numeric()
                            ->step(0.00000001),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Configuración')
                    ->schema([
                        Forms\Components\Toggle::make('activo')
                            ->label('Capilla activa')
                            ->default(true)
                            ->helperText('Las capillas inactivas no se muestran en el sitio público'),

                        Forms\Components\TextInput::make('orden')
                            ->numeric()
                            ->default(0)
                            ->helperText('Orden de aparición (menor = primero)'),
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
                    ->defaultImageUrl(fn () => 'https://ui-avatars.com/api/?name=C&background=6366f1&color=fff'),

                Tables\Columns\TextColumn::make('nombre')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('direccion')
                    ->label('Dirección')
                    ->limit(30)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('telefono')
                    ->label('Teléfono')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('mass_schedules_count')
                    ->label('Horarios')
                    ->counts('massSchedules')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('parish_groups_count')
                    ->label('Grupos')
                    ->counts('parishGroups')
                    ->badge()
                    ->color('success'),

                Tables\Columns\IconColumn::make('activo')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('orden')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('activo')
                    ->label('Estado')
                    ->placeholder('Todos')
                    ->trueLabel('Activas')
                    ->falseLabel('Inactivas'),
            ])
            ->actions([
                Tables\Actions\Action::make('traducir')
                    ->label('Traducir')
                    ->icon('heroicon-o-language')
                    ->color('info')
                    ->requiresConfirmation()
                    ->modalHeading('Traducir todos los campos')
                    ->modalDescription('Se traducirán todos los campos traducibles al inglés usando IA.')
                    ->modalSubmitActionLabel('Traducir ahora')
                    ->action(function (Chapel $record) {
                        TranslateContentJob::dispatch($record, $record->getTranslatableAttributes());
                        Notification::make()
                            ->title('Traducción iniciada')
                            ->body('Los campos se están traduciendo. Actualiza la página en unos segundos.')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('orden');
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
            'index' => Pages\ListChapels::route('/'),
            'create' => Pages\CreateChapel::route('/create'),
            'edit' => Pages\EditChapel::route('/{record}/edit'),
        ];
    }
}
