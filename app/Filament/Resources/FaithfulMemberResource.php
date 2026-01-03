<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FaithfulMemberResource\Pages;
use App\Models\Chapel;
use App\Models\FaithfulMember;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FaithfulMemberResource extends Resource
{
    protected static ?string $model = FaithfulMember::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Comunidad';

    protected static ?string $modelLabel = 'Fiel';

    protected static ?string $pluralModelLabel = 'Fieles';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Datos del Fiel')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Datos Personales')
                            ->icon('heroicon-o-user')
                            ->schema([
                                Forms\Components\Grid::make(3)
                                    ->schema([
                                        Forms\Components\TextInput::make('nombre')
                                            ->label('Nombre(s)')
                                            ->required()
                                            ->maxLength(255),

                                        Forms\Components\TextInput::make('apellido_paterno')
                                            ->label('Apellido Paterno')
                                            ->required()
                                            ->maxLength(255),

                                        Forms\Components\TextInput::make('apellido_materno')
                                            ->label('Apellido Materno')
                                            ->maxLength(255),
                                    ]),

                                Forms\Components\Grid::make(3)
                                    ->schema([
                                        Forms\Components\DatePicker::make('fecha_nacimiento')
                                            ->label('Fecha de Nacimiento')
                                            ->maxDate(now())
                                            ->native(false),

                                        Forms\Components\Select::make('genero')
                                            ->label('Género')
                                            ->options(FaithfulMember::GENEROS)
                                            ->native(false),

                                        Forms\Components\Select::make('estado_civil')
                                            ->label('Estado Civil')
                                            ->options(FaithfulMember::ESTADOS_CIVILES)
                                            ->native(false),
                                    ]),
                            ]),

                        Forms\Components\Tabs\Tab::make('Contacto')
                            ->icon('heroicon-o-phone')
                            ->schema([
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('email')
                                            ->label('Correo Electrónico')
                                            ->email()
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->maxLength(255),

                                        Forms\Components\TextInput::make('telefono')
                                            ->label('Teléfono')
                                            ->tel()
                                            ->maxLength(20),
                                    ]),

                                Forms\Components\TextInput::make('telefono_emergencia')
                                    ->label('Teléfono de Emergencia')
                                    ->tel()
                                    ->maxLength(20),

                                Forms\Components\Textarea::make('direccion')
                                    ->label('Dirección')
                                    ->rows(2)
                                    ->columnSpanFull(),

                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('colonia')
                                            ->label('Colonia')
                                            ->maxLength(255),

                                        Forms\Components\TextInput::make('codigo_postal')
                                            ->label('Código Postal')
                                            ->maxLength(10),
                                    ]),
                            ]),

                        Forms\Components\Tabs\Tab::make('Información Parroquial')
                            ->icon('heroicon-o-building-library')
                            ->schema([
                                Forms\Components\Select::make('chapel_id')
                                    ->label('Capilla Preferida')
                                    ->options(function () {
                                        $opciones = ['' => 'Templo Parroquial (Principal)'];
                                        return $opciones + Chapel::activo()->ordenado()->pluck('nombre', 'id')->toArray();
                                    })
                                    ->native(false)
                                    ->searchable(),

                                Forms\Components\Grid::make(3)
                                    ->schema([
                                        Forms\Components\DatePicker::make('fecha_bautismo')
                                            ->label('Fecha de Bautismo')
                                            ->native(false),

                                        Forms\Components\DatePicker::make('fecha_primera_comunion')
                                            ->label('Primera Comunión')
                                            ->native(false),

                                        Forms\Components\DatePicker::make('fecha_confirmacion')
                                            ->label('Confirmación')
                                            ->native(false),
                                    ]),

                                Forms\Components\Textarea::make('notas')
                                    ->label('Notas')
                                    ->rows(3)
                                    ->columnSpanFull(),
                            ]),

                        Forms\Components\Tabs\Tab::make('Preferencias')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                Forms\Components\Section::make('Comunicaciones')
                                    ->description('El fiel debe verificar su email para recibir comunicaciones')
                                    ->schema([
                                        Forms\Components\Toggle::make('recibir_newsletter')
                                            ->label('Recibir Newsletter')
                                            ->helperText('Boletín parroquial periódico'),

                                        Forms\Components\Toggle::make('recibir_eventos')
                                            ->label('Recibir Avisos de Eventos')
                                            ->helperText('Notificaciones de eventos próximos'),

                                        Forms\Components\Toggle::make('recibir_avisos')
                                            ->label('Recibir Avisos Generales')
                                            ->helperText('Comunicados importantes de la parroquia'),
                                    ])
                                    ->columns(3),

                                Forms\Components\Section::make('Estado')
                                    ->schema([
                                        Forms\Components\Toggle::make('activo')
                                            ->label('Fiel Activo')
                                            ->helperText('Los fieles inactivos no reciben comunicaciones')
                                            ->default(true),

                                        Forms\Components\Placeholder::make('verificacion')
                                            ->label('Estado de Verificación')
                                            ->content(fn (?FaithfulMember $record) =>
                                                $record?->email_verificado_at
                                                    ? '✅ Email verificado el ' . $record->email_verificado_at->format('d/m/Y H:i')
                                                    : '⏳ Pendiente de verificación'
                                            ),
                                    ])
                                    ->columns(2),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre_completo')
                    ->label('Nombre')
                    ->searchable(['nombre', 'apellido_paterno', 'apellido_materno'])
                    ->sortable(['apellido_paterno', 'nombre']),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-o-envelope'),

                Tables\Columns\TextColumn::make('telefono')
                    ->label('Teléfono')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('chapel.nombre')
                    ->label('Capilla')
                    ->default('Templo Parroquial')
                    ->badge()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('email_verificado_at')
                    ->label('Verificado')
                    ->boolean()
                    ->getStateUsing(fn ($record) => $record->email_verificado_at !== null)
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-clock')
                    ->trueColor('success')
                    ->falseColor('warning'),

                Tables\Columns\IconColumn::make('activo')
                    ->label('Activo')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Registrado')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('activo')
                    ->label('Estado')
                    ->placeholder('Todos')
                    ->trueLabel('Solo activos')
                    ->falseLabel('Solo inactivos'),

                Tables\Filters\TernaryFilter::make('verificado')
                    ->label('Verificación')
                    ->placeholder('Todos')
                    ->trueLabel('Email verificado')
                    ->falseLabel('Sin verificar')
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('email_verificado_at'),
                        false: fn (Builder $query) => $query->whereNull('email_verificado_at'),
                    ),

                Tables\Filters\SelectFilter::make('chapel_id')
                    ->label('Capilla')
                    ->relationship('chapel', 'nombre')
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('genero')
                    ->label('Género')
                    ->options(FaithfulMember::GENEROS),

                Tables\Filters\SelectFilter::make('estado_civil')
                    ->label('Estado Civil')
                    ->options(FaithfulMember::ESTADOS_CIVILES),

                Tables\Filters\Filter::make('con_newsletter')
                    ->label('Suscrito a Newsletter')
                    ->query(fn (Builder $query) => $query->where('recibir_newsletter', true))
                    ->toggle(),

                Tables\Filters\TrashedFilter::make()
                    ->label('Eliminados'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('reenviarVerificacion')
                        ->label('Reenviar Verificación')
                        ->icon('heroicon-o-envelope')
                        ->color('warning')
                        ->visible(fn (FaithfulMember $record) => $record->email_verificado_at === null)
                        ->requiresConfirmation()
                        ->action(fn (FaithfulMember $record) => $record->generarTokenVerificacion()),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No hay fieles registrados')
            ->emptyStateDescription('Los fieles pueden registrarse desde el sitio público o puedes agregarlos manualmente.')
            ->emptyStateIcon('heroicon-o-users');
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
            'index' => Pages\ListFaithfulMembers::route('/'),
            'create' => Pages\CreateFaithfulMember::route('/create'),
            'edit' => Pages\EditFaithfulMember::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
