<?php

namespace Database\Seeders;

use App\Models\Chapel;
use App\Models\MassSchedule;
use Illuminate\Database\Seeder;

class MassScheduleSeeder extends Seeder
{
    public function run(): void
    {
        // Horarios de la Parroquia Principal (chapel_id = null)
        $horariosParroquiaPrincipal = [
            // Domingo
            ['dia_semana' => 0, 'hora' => '08:00', 'tipo' => 'dominical', 'descripcion' => 'Misa dominical', 'orden' => 1],
            ['dia_semana' => 0, 'hora' => '10:00', 'tipo' => 'dominical', 'descripcion' => 'Misa con coro', 'orden' => 2],
            ['dia_semana' => 0, 'hora' => '12:00', 'tipo' => 'dominical', 'descripcion' => 'Misa dominical', 'orden' => 3],
            ['dia_semana' => 0, 'hora' => '19:00', 'tipo' => 'vespertina', 'descripcion' => 'Misa vespertina', 'orden' => 4],
            // Lunes a Viernes
            ['dia_semana' => 1, 'hora' => '07:00', 'tipo' => 'ordinaria', 'descripcion' => 'Misa matutina', 'orden' => 1],
            ['dia_semana' => 1, 'hora' => '19:00', 'tipo' => 'vespertina', 'descripcion' => 'Misa vespertina', 'orden' => 2],
            ['dia_semana' => 2, 'hora' => '07:00', 'tipo' => 'ordinaria', 'descripcion' => 'Misa matutina', 'orden' => 1],
            ['dia_semana' => 2, 'hora' => '19:00', 'tipo' => 'vespertina', 'descripcion' => 'Misa vespertina', 'orden' => 2],
            ['dia_semana' => 3, 'hora' => '07:00', 'tipo' => 'ordinaria', 'descripcion' => 'Misa matutina', 'orden' => 1],
            ['dia_semana' => 3, 'hora' => '19:00', 'tipo' => 'vespertina', 'descripcion' => 'Misa vespertina', 'orden' => 2],
            ['dia_semana' => 4, 'hora' => '07:00', 'tipo' => 'ordinaria', 'descripcion' => 'Misa matutina', 'orden' => 1],
            ['dia_semana' => 4, 'hora' => '19:00', 'tipo' => 'vespertina', 'descripcion' => 'Hora Santa después de misa', 'orden' => 2],
            ['dia_semana' => 5, 'hora' => '07:00', 'tipo' => 'ordinaria', 'descripcion' => 'Misa matutina', 'orden' => 1],
            ['dia_semana' => 5, 'hora' => '19:00', 'tipo' => 'vespertina', 'descripcion' => 'Misa vespertina', 'orden' => 2],
            // Sábado
            ['dia_semana' => 6, 'hora' => '08:00', 'tipo' => 'ordinaria', 'descripcion' => 'Misa matutina', 'orden' => 1],
            ['dia_semana' => 6, 'hora' => '19:00', 'tipo' => 'dominical', 'descripcion' => 'Vigilia dominical', 'orden' => 2],
        ];

        foreach ($horariosParroquiaPrincipal as $horario) {
            MassSchedule::create(array_merge($horario, [
                'chapel_id' => null,
                'idioma' => 'es',
                'activo' => true,
            ]));
        }

        // Horarios por capilla
        $capillas = Chapel::all();

        // Capilla San José
        $capillaSanJose = $capillas->where('slug', 'capilla-san-jose')->first();
        if ($capillaSanJose) {
            $horariosSanJose = [
                ['dia_semana' => 0, 'hora' => '09:00', 'tipo' => 'dominical', 'descripcion' => 'Misa dominical', 'orden' => 1],
                ['dia_semana' => 0, 'hora' => '18:00', 'tipo' => 'vespertina', 'descripcion' => 'Misa vespertina', 'orden' => 2],
                ['dia_semana' => 2, 'hora' => '18:00', 'tipo' => 'ordinaria', 'descripcion' => 'Misa entre semana', 'orden' => 1],
                ['dia_semana' => 4, 'hora' => '18:00', 'tipo' => 'ordinaria', 'descripcion' => 'Misa entre semana', 'orden' => 1],
                ['dia_semana' => 6, 'hora' => '18:00', 'tipo' => 'dominical', 'descripcion' => 'Vigilia dominical', 'orden' => 1],
            ];

            foreach ($horariosSanJose as $horario) {
                MassSchedule::create(array_merge($horario, [
                    'chapel_id' => $capillaSanJose->id,
                    'idioma' => 'es',
                    'activo' => true,
                ]));
            }
        }

        // Capilla Nuestra Señora de Guadalupe
        $capillaGuadalupe = $capillas->where('slug', 'capilla-guadalupe')->first();
        if ($capillaGuadalupe) {
            $horariosGuadalupe = [
                ['dia_semana' => 0, 'hora' => '10:00', 'tipo' => 'dominical', 'descripcion' => 'Misa dominical', 'orden' => 1],
                ['dia_semana' => 0, 'hora' => '19:00', 'tipo' => 'vespertina', 'descripcion' => 'Misa vespertina', 'orden' => 2],
                ['dia_semana' => 1, 'hora' => '19:00', 'tipo' => 'ordinaria', 'descripcion' => 'Misa entre semana', 'orden' => 1],
                ['dia_semana' => 3, 'hora' => '19:00', 'tipo' => 'ordinaria', 'descripcion' => 'Misa entre semana', 'orden' => 1],
                ['dia_semana' => 5, 'hora' => '19:00', 'tipo' => 'ordinaria', 'descripcion' => 'Misa entre semana', 'orden' => 1],
                ['dia_semana' => 6, 'hora' => '19:00', 'tipo' => 'dominical', 'descripcion' => 'Vigilia dominical', 'orden' => 1],
            ];

            foreach ($horariosGuadalupe as $horario) {
                MassSchedule::create(array_merge($horario, [
                    'chapel_id' => $capillaGuadalupe->id,
                    'idioma' => 'es',
                    'activo' => true,
                ]));
            }
        }

        // Capilla del Sagrado Corazón
        $capillaSagradoCorazon = $capillas->where('slug', 'capilla-sagrado-corazon')->first();
        if ($capillaSagradoCorazon) {
            $horariosSagradoCorazon = [
                ['dia_semana' => 0, 'hora' => '11:00', 'tipo' => 'dominical', 'descripcion' => 'Misa dominical', 'orden' => 1],
                ['dia_semana' => 0, 'hora' => '18:30', 'tipo' => 'vespertina', 'descripcion' => 'Misa vespertina', 'orden' => 2],
                ['dia_semana' => 2, 'hora' => '19:00', 'tipo' => 'ordinaria', 'descripcion' => 'Misa entre semana', 'orden' => 1],
                ['dia_semana' => 4, 'hora' => '19:00', 'tipo' => 'ordinaria', 'descripcion' => 'Hora Santa y Misa', 'orden' => 1],
                ['dia_semana' => 6, 'hora' => '18:30', 'tipo' => 'dominical', 'descripcion' => 'Vigilia dominical', 'orden' => 1],
            ];

            foreach ($horariosSagradoCorazon as $horario) {
                MassSchedule::create(array_merge($horario, [
                    'chapel_id' => $capillaSagradoCorazon->id,
                    'idioma' => 'es',
                    'activo' => true,
                ]));
            }
        }
    }
}
