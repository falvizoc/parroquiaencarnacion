<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PriestResource\Pages;
use App\Jobs\TranslateContentJob;
use App\Models\Priest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PriestResource extends Resource
{
    use Translatable;
    protected static ?string $model = Priest::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationGroup = 'Parroquia';

    protected static ?string $modelLabel = 'Sacerdote';

    protected static ?string $pluralModelLabel = 'Sacerdotes';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información Personal')
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

                        Forms\Components\Select::make('titulo')
                            ->label('Título')
                            ->options(Priest::TITULOS)
                            ->native(false)
                            ->default('pbro'),

                        Forms\Components\Select::make('cargo')
                            ->options(Priest::CARGOS)
                            ->required()
                            ->native(false)
                            ->default('vicario')
                            ->helperText('Solo puede haber un párroco activo')
                            ->live(),

                        Forms\Components\FileUpload::make('foto')
                            ->image()
                            ->directory('sacerdotes')
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('3:4')
                            ->imageResizeTargetWidth('600')
                            ->imageResizeTargetHeight('800')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Mensaje y Biografía')
                    ->schema([
                        Forms\Components\RichEditor::make('mensaje')
                            ->label('Mensaje Personal')
                            ->helperText('Mensaje del sacerdote para la comunidad')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('biografia')
                            ->label('Biografía')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Contacto')
                    ->schema([
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('telefono')
                            ->label('Teléfono')
                            ->tel()
                            ->maxLength(20),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Fechas')
                    ->schema([
                        Forms\Components\DatePicker::make('fecha_ordenacion')
                            ->label('Fecha de Ordenación')
                            ->native(false)
                            ->displayFormat('d/m/Y'),

                        Forms\Components\DatePicker::make('fecha_asignacion')
                            ->label('Fecha de Asignación')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->helperText('Fecha de asignación a esta parroquia'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Configuración')
                    ->schema([
                        Forms\Components\Toggle::make('activo')
                            ->label('Sacerdote activo')
                            ->default(true)
                            ->helperText('Los sacerdotes inactivos no se muestran en el sitio público'),

                        Forms\Components\TextInput::make('orden')
                            ->numeric()
                            ->default(0)
                            ->helperText('Orden de aparición (el párroco siempre aparece primero)'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('foto')
                    ->circular()
                    ->defaultImageUrl(fn () => 'https://ui-avatars.com/api/?name=P&background=6366f1&color=fff'),

                Tables\Columns\TextColumn::make('nombre_completo')
                    ->label('Nombre')
                    ->searchable(['nombre'])
                    ->sortable(['nombre']),

                Tables\Columns\TextColumn::make('cargo')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => Priest::CARGOS[$state] ?? $state)
                    ->color(fn (string $state): string => match ($state) {
                        'parroco' => 'warning',
                        'vicario' => 'info',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('email')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('telefono')
                    ->label('Teléfono')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('fecha_asignacion')
                    ->label('Asignación')
                    ->date('d/m/Y')
                    ->sortable()
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

                Tables\Filters\SelectFilter::make('cargo')
                    ->options(Priest::CARGOS),
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
                    ->action(function (Priest $record) {
                        TranslateContentJob::dispatch($record, $record->getTranslatableAttributes());
                        Notification::make()
                            ->title('Traducción iniciada')
                            ->body('Los campos se están traduciendo. Actualiza la página en unos segundos.')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function (Priest $record) {
                        if ($record->isParroco()) {
                            Notification::make()
                                ->warning()
                                ->title('Advertencia')
                                ->body('Está eliminando al párroco. Asegúrese de asignar uno nuevo.')
                                ->send();
                        }
                    }),
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
            'index' => Pages\ListPriests::route('/'),
            'create' => Pages\CreatePriest::route('/create'),
            'edit' => Pages\EditPriest::route('/{record}/edit'),
        ];
    }
}
