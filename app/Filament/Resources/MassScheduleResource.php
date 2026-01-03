<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MassScheduleResource\Pages;
use App\Models\Chapel;
use App\Models\MassSchedule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MassScheduleResource extends Resource
{
    protected static ?string $model = MassSchedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $navigationGroup = 'Contenido';

    protected static ?string $modelLabel = 'Horario de Misa';

    protected static ?string $pluralModelLabel = 'Horarios de Misa';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del Horario')
                    ->schema([
                        Forms\Components\Select::make('chapel_id')
                            ->label('Ubicación')
                            ->options(function () {
                                $opciones = ['' => '🏛️ Templo Parroquial (Principal)'];
                                $capillas = Chapel::activo()->ordenado()->pluck('nombre', 'id')->toArray();
                                foreach ($capillas as $id => $nombre) {
                                    $opciones[$id] = '⛪ ' . $nombre;
                                }
                                return $opciones;
                            })
                            ->default('')
                            ->helperText('Selecciona dónde se celebrará la misa')
                            ->native(false)
                            ->searchable(),

                        Forms\Components\Select::make('dia_semana')
                            ->label('Día de la semana')
                            ->options(MassSchedule::DIAS_SEMANA)
                            ->required()
                            ->native(false),

                        Forms\Components\TimePicker::make('hora')
                            ->label('Hora')
                            ->required()
                            ->seconds(false),

                        Forms\Components\Select::make('tipo')
                            ->label('Tipo de misa')
                            ->options(MassSchedule::TIPOS)
                            ->default('ordinaria')
                            ->required()
                            ->native(false),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Detalles Adicionales')
                    ->schema([
                        Forms\Components\TextInput::make('descripcion')
                            ->label('Descripción')
                            ->placeholder('Ej: Misa con coro, Misa de niños, etc.')
                            ->maxLength(255),

                        Forms\Components\Select::make('idioma')
                            ->label('Idioma')
                            ->options([
                                'es' => 'Español',
                                'en' => 'Inglés',
                                'la' => 'Latín',
                            ])
                            ->default('es')
                            ->native(false),

                        Forms\Components\Textarea::make('notas')
                            ->label('Notas')
                            ->placeholder('Información adicional para el equipo administrativo')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsed(),

                Forms\Components\Section::make('Configuración')
                    ->schema([
                        Forms\Components\Toggle::make('activo')
                            ->label('Activo')
                            ->helperText('Los horarios inactivos no se muestran en el sitio público')
                            ->default(true),

                        Forms\Components\TextInput::make('orden')
                            ->label('Orden')
                            ->numeric()
                            ->default(0)
                            ->helperText('Para ordenar horarios del mismo día y hora'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('chapel.nombre')
                    ->label('Ubicación')
                    ->default('Templo Parroquial')
                    ->badge()
                    ->color(fn (?string $state): string => $state === 'Templo Parroquial' ? 'primary' : 'gray')
                    ->sortable(),

                Tables\Columns\TextColumn::make('nombre_dia')
                    ->label('Día')
                    ->sortable(query: fn ($query, $direction) => $query->orderBy('dia_semana', $direction))
                    ->badge()
                    ->color(fn (MassSchedule $record): string => match ($record->dia_semana) {
                        0 => 'success',    // Domingo - verde
                        6 => 'warning',    // Sábado - amarillo
                        default => 'gray', // Entre semana
                    }),

                Tables\Columns\TextColumn::make('hora')
                    ->label('Hora')
                    ->time('H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('nombre_tipo')
                    ->label('Tipo')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->limit(30)
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\IconColumn::make('activo')
                    ->label('Activo')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('dia_semana')
            ->filters([
                Tables\Filters\SelectFilter::make('ubicacion')
                    ->label('Ubicación')
                    ->options(function () {
                        $opciones = ['templo_parroquial' => '🏛️ Templo Parroquial'];
                        $capillas = Chapel::activo()->ordenado()->pluck('nombre', 'id')->toArray();
                        foreach ($capillas as $id => $nombre) {
                            $opciones[$id] = '⛪ ' . $nombre;
                        }
                        return $opciones;
                    })
                    ->query(function ($query, array $data) {
                        if (empty($data['value'])) {
                            return $query;
                        }
                        if ($data['value'] === 'templo_parroquial') {
                            return $query->whereNull('chapel_id');
                        }
                        return $query->where('chapel_id', $data['value']);
                    })
                    ->placeholder('Todas las ubicaciones'),

                Tables\Filters\SelectFilter::make('dia_semana')
                    ->label('Día')
                    ->options(MassSchedule::DIAS_SEMANA),

                Tables\Filters\SelectFilter::make('tipo')
                    ->label('Tipo')
                    ->options(MassSchedule::TIPOS),

                Tables\Filters\TernaryFilter::make('activo')
                    ->label('Estado')
                    ->placeholder('Todos')
                    ->trueLabel('Solo activos')
                    ->falseLabel('Solo inactivos'),
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
            ->emptyStateHeading('No hay horarios de misa')
            ->emptyStateDescription('Crea el primer horario para comenzar.')
            ->emptyStateIcon('heroicon-o-clock');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMassSchedules::route('/'),
            'create' => Pages\CreateMassSchedule::route('/create'),
            'edit' => Pages\EditMassSchedule::route('/{record}/edit'),
        ];
    }
}
