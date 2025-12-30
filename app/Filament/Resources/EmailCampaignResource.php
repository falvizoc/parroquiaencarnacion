<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmailCampaignResource\Pages;
use App\Filament\Resources\EmailCampaignResource\RelationManagers;
use App\Models\Chapel;
use App\Models\EmailCampaign;
use App\Models\EmailTemplate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;

class EmailCampaignResource extends Resource
{
    protected static ?string $model = EmailCampaign::class;

    protected static ?string $navigationIcon = 'heroicon-o-paper-airplane';

    protected static ?string $navigationGroup = 'Comunicaciones';

    protected static ?string $navigationLabel = 'Campañas de Email';

    protected static ?string $modelLabel = 'Campaña';

    protected static ?string $pluralModelLabel = 'Campañas de Email';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Campaña')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Información')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Forms\Components\TextInput::make('nombre')
                                    ->label('Nombre de la Campaña')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                Forms\Components\Select::make('tipo')
                                    ->label('Tipo')
                                    ->options(EmailCampaign::TIPOS)
                                    ->required()
                                    ->native(false),

                                Forms\Components\Select::make('email_template_id')
                                    ->label('Plantilla Base')
                                    ->relationship('template', 'nombre', fn ($query) => $query->activo())
                                    ->preload()
                                    ->searchable()
                                    ->helperText('Opcional: selecciona una plantilla para cargar su contenido')
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                                        if ($state) {
                                            $template = EmailTemplate::find($state);
                                            if ($template) {
                                                $set('asunto', $template->asunto);
                                                $set('contenido', $template->contenido);
                                            }
                                        }
                                    }),
                            ])
                            ->columns(2),

                        Forms\Components\Tabs\Tab::make('Contenido')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Forms\Components\TextInput::make('asunto')
                                    ->label('Asunto del Email')
                                    ->required()
                                    ->maxLength(255)
                                    ->helperText('Puedes usar variables: {{nombre}}, {{nombre_completo}}'),

                                Forms\Components\RichEditor::make('contenido')
                                    ->label('Contenido del Email')
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

                        Forms\Components\Tabs\Tab::make('Destinatarios')
                            ->icon('heroicon-o-users')
                            ->schema([
                                Forms\Components\Select::make('segmentacion.tipo')
                                    ->label('Segmento de Destinatarios')
                                    ->options(EmailCampaign::SEGMENTACION_OPCIONES)
                                    ->default('todos')
                                    ->required()
                                    ->live()
                                    ->native(false),

                                Forms\Components\Select::make('segmentacion.chapel_id')
                                    ->label('Capilla Específica')
                                    ->options(fn () => Chapel::pluck('nombre', 'id'))
                                    ->searchable()
                                    ->visible(fn (Forms\Get $get) => $get('segmentacion.tipo') === 'capilla')
                                    ->required(fn (Forms\Get $get) => $get('segmentacion.tipo') === 'capilla'),

                                Forms\Components\Placeholder::make('preview_destinatarios')
                                    ->label('Vista Previa de Destinatarios')
                                    ->content(function (Forms\Get $get) {
                                        $segmentacion = $get('segmentacion') ?? [];

                                        $query = \App\Models\FaithfulMember::activo()->verificado();

                                        if (isset($segmentacion['tipo'])) {
                                            match ($segmentacion['tipo']) {
                                                'newsletter' => $query->conNewsletter(),
                                                'eventos' => $query->conEventos(),
                                                'avisos' => $query->conAvisos(),
                                                default => null,
                                            };
                                        }

                                        if (!empty($segmentacion['chapel_id'])) {
                                            $query->where('chapel_id', $segmentacion['chapel_id']);
                                        }

                                        $total = $query->count();
                                        return new \Illuminate\Support\HtmlString(
                                            "<span class='text-lg font-bold text-primary-600'>{$total}</span> destinatarios coinciden con los criterios"
                                        );
                                    })
                                    ->columnSpanFull(),
                            ]),

                        Forms\Components\Tabs\Tab::make('Programación')
                            ->icon('heroicon-o-clock')
                            ->schema([
                                Forms\Components\Radio::make('envio_tipo')
                                    ->label('Momento de Envío')
                                    ->options([
                                        'ahora' => 'Enviar ahora (al guardar)',
                                        'programar' => 'Programar para después',
                                    ])
                                    ->default('ahora')
                                    ->live()
                                    ->dehydrated(false),

                                Forms\Components\DateTimePicker::make('programada_para')
                                    ->label('Fecha y Hora de Envío')
                                    ->visible(fn (Forms\Get $get) => $get('envio_tipo') === 'programar')
                                    ->required(fn (Forms\Get $get) => $get('envio_tipo') === 'programar')
                                    ->minDate(now())
                                    ->native(false),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Campaña')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nombre_tipo')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Newsletter' => 'info',
                        'Evento' => 'warning',
                        'Aviso' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('nombre_estado')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (EmailCampaign $record): string => $record->color_estado),

                Tables\Columns\TextColumn::make('total_destinatarios')
                    ->label('Destinatarios')
                    ->numeric()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('enviados')
                    ->label('Enviados')
                    ->numeric()
                    ->alignCenter()
                    ->color('success'),

                Tables\Columns\TextColumn::make('fallidos')
                    ->label('Fallidos')
                    ->numeric()
                    ->alignCenter()
                    ->color('danger'),

                Tables\Columns\TextColumn::make('porcentaje_enviado')
                    ->label('Progreso')
                    ->formatStateUsing(fn ($state) => $state . '%')
                    ->badge()
                    ->color(fn ($state) => $state >= 100 ? 'success' : ($state > 0 ? 'warning' : 'gray')),

                Tables\Columns\TextColumn::make('creador.name')
                    ->label('Creado por')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('programada_para')
                    ->label('Programada')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('enviada_at')
                    ->label('Enviada')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('estado')
                    ->label('Estado')
                    ->options(EmailCampaign::ESTADOS),

                Tables\Filters\SelectFilter::make('tipo')
                    ->label('Tipo')
                    ->options(EmailCampaign::TIPOS),
            ])
            ->actions([
                Tables\Actions\Action::make('enviar')
                    ->label('Enviar')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('success')
                    ->visible(fn (EmailCampaign $record) => $record->puedeEnviarse())
                    ->requiresConfirmation()
                    ->modalHeading('Enviar Campaña')
                    ->modalDescription(fn (EmailCampaign $record) => "¿Estás seguro de enviar la campaña '{$record->nombre}'? Se enviará a {$record->obtenerDestinatarios()->count()} destinatarios.")
                    ->action(function (EmailCampaign $record) {
                        // Dispatch job para envío
                        dispatch(new \App\Jobs\EnviarCampanaEmail($record));

                        Notification::make()
                            ->title('Campaña en proceso de envío')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('cancelar')
                    ->label('Cancelar')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (EmailCampaign $record) => $record->puedeCancelarse())
                    ->requiresConfirmation()
                    ->action(function (EmailCampaign $record) {
                        $record->update(['estado' => 'cancelada']);

                        Notification::make()
                            ->title('Campaña cancelada')
                            ->warning()
                            ->send();
                    }),

                Tables\Actions\Action::make('duplicar')
                    ->label('Duplicar')
                    ->icon('heroicon-o-document-duplicate')
                    ->color('gray')
                    ->action(function (EmailCampaign $record) {
                        $nuevo = $record->replicate(['enviada_at', 'total_destinatarios', 'enviados', 'fallidos']);
                        $nuevo->nombre = $record->nombre . ' (copia)';
                        $nuevo->estado = 'borrador';
                        $nuevo->save();

                        Notification::make()
                            ->title('Campaña duplicada')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn (EmailCampaign $record) => $record->puedeEnviarse()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function ($records) {
                            // Solo permitir eliminar borradores
                            foreach ($records as $record) {
                                if ($record->estado !== 'borrador') {
                                    Notification::make()
                                        ->title('No se pueden eliminar campañas que ya fueron enviadas o programadas')
                                        ->danger()
                                        ->send();
                                    return false;
                                }
                            }
                        }),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\LogsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmailCampaigns::route('/'),
            'create' => Pages\CreateEmailCampaign::route('/create'),
            'view' => Pages\ViewEmailCampaign::route('/{record}'),
            'edit' => Pages\EditEmailCampaign::route('/{record}/edit'),
        ];
    }
}
