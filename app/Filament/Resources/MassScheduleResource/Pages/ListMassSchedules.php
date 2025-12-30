<?php

namespace App\Filament\Resources\MassScheduleResource\Pages;

use App\Filament\Resources\MassScheduleResource;
use App\Models\Chapel;
use App\Models\MassSchedule;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListMassSchedules extends ListRecords
{
    protected static string $resource = MassScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('crearMasivo')
                ->label('Crear Horarios Recurrentes')
                ->icon('heroicon-o-calendar-days')
                ->color('success')
                ->form([
                    Forms\Components\Section::make('Ubicación y Horario')
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
                                ->native(false),

                            Forms\Components\TimePicker::make('hora')
                                ->label('Hora de la misa')
                                ->required()
                                ->seconds(false),
                        ])
                        ->columns(2),

                    Forms\Components\Section::make('Días de la Semana')
                        ->description('Selecciona los días en que se celebrará esta misa')
                        ->schema([
                            Forms\Components\CheckboxList::make('dias')
                                ->label('')
                                ->options(MassSchedule::DIAS_SEMANA)
                                ->columns(4)
                                ->required()
                                ->bulkToggleable(),
                        ]),

                    Forms\Components\Section::make('Detalles')
                        ->schema([
                            Forms\Components\Select::make('tipo')
                                ->label('Tipo de misa')
                                ->options(MassSchedule::TIPOS)
                                ->default('ordinaria')
                                ->required()
                                ->native(false),

                            Forms\Components\Select::make('idioma')
                                ->label('Idioma')
                                ->options([
                                    'es' => 'Español',
                                    'en' => 'Inglés',
                                    'la' => 'Latín',
                                ])
                                ->default('es')
                                ->native(false),

                            Forms\Components\TextInput::make('descripcion')
                                ->label('Descripción')
                                ->placeholder('Ej: Misa con coro, Misa de niños, etc.')
                                ->maxLength(255)
                                ->columnSpanFull(),
                        ])
                        ->columns(2)
                        ->collapsed(),
                ])
                ->action(function (array $data): void {
                    $creados = 0;
                    $omitidos = 0;

                    foreach ($data['dias'] as $dia) {
                        // Verificar si ya existe un horario igual
                        $existe = MassSchedule::where('chapel_id', $data['chapel_id'] ?: null)
                            ->where('dia_semana', $dia)
                            ->where('hora', $data['hora'])
                            ->exists();

                        if ($existe) {
                            $omitidos++;
                            continue;
                        }

                        MassSchedule::create([
                            'chapel_id' => $data['chapel_id'] ?: null,
                            'dia_semana' => $dia,
                            'hora' => $data['hora'],
                            'tipo' => $data['tipo'],
                            'idioma' => $data['idioma'] ?? 'es',
                            'descripcion' => $data['descripcion'] ?? null,
                            'activo' => true,
                        ]);
                        $creados++;
                    }

                    if ($creados > 0) {
                        Notification::make()
                            ->title('Horarios creados')
                            ->body("Se crearon {$creados} horario(s) de misa." . ($omitidos > 0 ? " {$omitidos} ya existían." : ''))
                            ->success()
                            ->send();
                    } else {
                        Notification::make()
                            ->title('Sin cambios')
                            ->body('Todos los horarios seleccionados ya existían.')
                            ->warning()
                            ->send();
                    }
                })
                ->modalHeading('Crear Horarios Recurrentes')
                ->modalDescription('Crea múltiples horarios de misa a la vez seleccionando varios días.')
                ->modalSubmitActionLabel('Crear Horarios')
                ->modalWidth('lg'),

            Actions\CreateAction::make()
                ->label('Crear Individual'),
        ];
    }
}
