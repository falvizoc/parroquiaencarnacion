<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParishGroupResource\Pages;
use App\Jobs\TranslateContentJob;
use App\Models\Chapel;
use App\Models\ParishGroup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ParishGroupResource extends Resource
{
    use Translatable;
    protected static ?string $model = ParishGroup::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Contenido';

    protected static ?string $modelLabel = 'Grupo Parroquial';

    protected static ?string $pluralModelLabel = 'Grupos Parroquiales';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Ubicación')
                    ->schema([
                        Forms\Components\Select::make('chapel_id')
                            ->label('Capilla')
                            ->relationship('chapel', 'nombre')
                            ->placeholder('Parroquia Principal')
                            ->helperText('Dejar vacío para grupos de la parroquia principal')
                            ->native(false)
                            ->searchable()
                            ->preload(),
                    ]),

                Forms\Components\Section::make('Información del Grupo')
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

                        Forms\Components\Textarea::make('descripcion_corta')
                            ->label('Descripción corta')
                            ->rows(2)
                            ->maxLength(500)
                            ->helperText('Resumen breve para mostrar en listados (máx. 500 caracteres)'),

                        Forms\Components\RichEditor::make('descripcion')
                            ->label('Descripción completa')
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('imagen')
                            ->image()
                            ->directory('grupos')
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('800')
                            ->imageResizeTargetHeight('450'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Horario de Reuniones')
                    ->schema([
                        Forms\Components\Select::make('dia_reunion')
                            ->label('Día de reunión')
                            ->options(ParishGroup::DIAS_SEMANA)
                            ->native(false),

                        Forms\Components\TimePicker::make('hora_reunion')
                            ->label('Hora de reunión')
                            ->seconds(false),

                        Forms\Components\TextInput::make('lugar_reunion')
                            ->label('Lugar de reunión')
                            ->maxLength(255),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Coordinador')
                    ->schema([
                        Forms\Components\TextInput::make('coordinador_nombre')
                            ->label('Nombre')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('coordinador_telefono')
                            ->label('Teléfono')
                            ->tel()
                            ->maxLength(20),

                        Forms\Components\TextInput::make('coordinador_email')
                            ->label('Correo electrónico')
                            ->email()
                            ->maxLength(255),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Configuración')
                    ->schema([
                        Forms\Components\Toggle::make('activo')
                            ->label('Grupo activo')
                            ->default(true)
                            ->helperText('Los grupos inactivos no se muestran en el sitio público'),

                        Forms\Components\TextInput::make('orden')
                            ->label('Orden de visualización')
                            ->numeric()
                            ->default(0)
                            ->helperText('Menor número = aparece primero'),
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
                    ->defaultImageUrl(fn () => 'https://ui-avatars.com/api/?name=G&background=6366f1&color=fff'),

                Tables\Columns\TextColumn::make('nombre')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('chapel.nombre')
                    ->label('Capilla')
                    ->default('Parroquia Principal')
                    ->badge()
                    ->color(fn (?string $state): string => $state === 'Parroquia Principal' ? 'primary' : 'gray')
                    ->sortable(),

                Tables\Columns\TextColumn::make('coordinador_nombre')
                    ->label('Coordinador')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('horario_formateado')
                    ->label('Horario')
                    ->toggleable(),

                Tables\Columns\IconColumn::make('activo')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('orden')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('chapel_id')
                    ->label('Capilla')
                    ->relationship('chapel', 'nombre')
                    ->placeholder('Todas')
                    ->searchable()
                    ->preload(),

                Tables\Filters\TernaryFilter::make('parroquia_principal')
                    ->label('Parroquia Principal')
                    ->placeholder('Todas las ubicaciones')
                    ->trueLabel('Solo Parroquia Principal')
                    ->falseLabel('Solo Capillas')
                    ->queries(
                        true: fn ($query) => $query->whereNull('chapel_id'),
                        false: fn ($query) => $query->whereNotNull('chapel_id'),
                    ),

                Tables\Filters\TernaryFilter::make('activo')
                    ->label('Estado')
                    ->placeholder('Todos')
                    ->trueLabel('Activos')
                    ->falseLabel('Inactivos'),

                Tables\Filters\SelectFilter::make('dia_reunion')
                    ->label('Día de reunión')
                    ->options(ParishGroup::DIAS_SEMANA),
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
                    ->action(function (ParishGroup $record) {
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
            ->defaultSort('orden')
            ->reorderable('orden');
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
            'index' => Pages\ListParishGroups::route('/'),
            'create' => Pages\CreateParishGroup::route('/create'),
            'edit' => Pages\EditParishGroup::route('/{record}/edit'),
        ];
    }
}
