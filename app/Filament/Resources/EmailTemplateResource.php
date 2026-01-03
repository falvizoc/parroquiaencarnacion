<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmailTemplateResource\Pages;
use App\Jobs\TranslateContentJob;
use App\Models\EmailTemplate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EmailTemplateResource extends Resource
{
    use Translatable;
    protected static ?string $model = EmailTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Comunicaciones';

    protected static ?string $navigationLabel = 'Plantillas de Email';

    protected static ?string $modelLabel = 'Plantilla';

    protected static ?string $pluralModelLabel = 'Plantillas de Email';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información General')
                    ->schema([
                        Forms\Components\TextInput::make('nombre')
                            ->label('Nombre de la Plantilla')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, Forms\Set $set) =>
                                $set('slug', \Illuminate\Support\Str::slug($state))
                            ),

                        Forms\Components\TextInput::make('slug')
                            ->label('Identificador')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Se genera automáticamente del nombre'),

                        Forms\Components\Select::make('tipo')
                            ->label('Tipo de Plantilla')
                            ->options(EmailTemplate::TIPOS)
                            ->required()
                            ->native(false),

                        Forms\Components\Toggle::make('activo')
                            ->label('Plantilla Activa')
                            ->default(true)
                            ->helperText('Las plantillas inactivas no aparecen al crear campañas'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Contenido del Email')
                    ->schema([
                        Forms\Components\TextInput::make('asunto')
                            ->label('Asunto del Email')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Puedes usar variables como {{nombre}}'),

                        Forms\Components\RichEditor::make('contenido')
                            ->label('Contenido')
                            ->required()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'link',
                                'orderedList',
                                'bulletList',
                                'h2',
                                'h3',
                                'blockquote',
                                'redo',
                                'undo',
                            ])
                            ->columnSpanFull(),

                        Forms\Components\Placeholder::make('variables_disponibles')
                            ->label('Variables Disponibles')
                            ->content(function () {
                                $variables = collect(EmailTemplate::VARIABLES_DISPONIBLES)
                                    ->map(fn ($desc, $var) => "<code>{$var}</code> - {$desc}")
                                    ->join('<br>');
                                return new \Illuminate\Support\HtmlString($variables);
                            })
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nombre_tipo')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Newsletter' => 'info',
                        'Evento' => 'warning',
                        'Aviso' => 'danger',
                        'Bienvenida' => 'success',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('asunto')
                    ->label('Asunto')
                    ->searchable()
                    ->limit(40),

                Tables\Columns\IconColumn::make('activo')
                    ->label('Activa')
                    ->boolean(),

                Tables\Columns\TextColumn::make('campaigns_count')
                    ->label('Campañas')
                    ->counts('campaigns')
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Última Modificación')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('updated_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('tipo')
                    ->label('Tipo')
                    ->options(EmailTemplate::TIPOS),

                Tables\Filters\TernaryFilter::make('activo')
                    ->label('Estado')
                    ->placeholder('Todas')
                    ->trueLabel('Solo activas')
                    ->falseLabel('Solo inactivas'),
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
                    ->action(function (EmailTemplate $record) {
                        TranslateContentJob::dispatch($record, $record->getTranslatableAttributes());
                        Notification::make()
                            ->title('Traducción iniciada')
                            ->body('Los campos se están traduciendo. Actualiza la página en unos segundos.')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\Action::make('duplicar')
                    ->label('Duplicar')
                    ->icon('heroicon-o-document-duplicate')
                    ->color('gray')
                    ->action(function (EmailTemplate $record) {
                        $nuevo = $record->replicate();
                        $nuevo->nombre = $record->nombre . ' (copia)';
                        $nuevo->slug = $record->slug . '-copia-' . now()->timestamp;
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
            'index' => Pages\ListEmailTemplates::route('/'),
            'create' => Pages\CreateEmailTemplate::route('/create'),
            'edit' => Pages\EditEmailTemplate::route('/{record}/edit'),
        ];
    }
}
