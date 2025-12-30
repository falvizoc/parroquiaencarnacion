<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $eventos = [
            [
                'titulo' => 'Misa de Año Nuevo',
                'slug' => 'misa-ano-nuevo-2025',
                'descripcion_corta' => 'Celebración eucarística para dar gracias por el año que termina y pedir bendiciones para el nuevo año.',
                'descripcion' => '<p>Te invitamos a iniciar el año 2025 en comunidad, dando gracias a Dios por las bendiciones recibidas y pidiendo su guía para el nuevo año.</p>',
                'fecha_inicio' => Carbon::create(2025, 1, 1),
                'hora_inicio' => '12:00',
                'lugar' => 'Templo Principal',
                'categoria' => 'liturgico',
                'es_destacado' => true,
                'activo' => true,
            ],
            [
                'titulo' => 'Retiro de Cuaresma',
                'slug' => 'retiro-cuaresma-2025',
                'descripcion_corta' => 'Jornada de reflexión y oración para preparar nuestros corazones para la Semana Santa.',
                'descripcion' => '<p>Un día completo de retiro espiritual para profundizar en nuestra fe y prepararnos para vivir intensamente la Pascua.</p><p>Incluye conferencias, adoración eucarística y sacramento de la reconciliación.</p>',
                'fecha_inicio' => Carbon::create(2025, 3, 15),
                'hora_inicio' => '09:00',
                'hora_fin' => '17:00',
                'lugar' => 'Casa de Retiros San José',
                'categoria' => 'formacion',
                'es_destacado' => true,
                'activo' => true,
            ],
            [
                'titulo' => 'Kermés Parroquial',
                'slug' => 'kermes-parroquial-2025',
                'descripcion_corta' => 'Fiesta familiar con comida, juegos y actividades para recaudar fondos para las obras de la parroquia.',
                'descripcion' => '<p>Únete a nuestra tradicional kermés parroquial. Habrá antojitos mexicanos, juegos para niños y adultos, rifa de premios y mucha diversión.</p><p>Los fondos recaudados se destinarán a la restauración del templo.</p>',
                'fecha_inicio' => Carbon::create(2025, 4, 20),
                'hora_inicio' => '11:00',
                'hora_fin' => '18:00',
                'lugar' => 'Atrio de la Parroquia',
                'categoria' => 'social',
                'es_destacado' => false,
                'activo' => true,
            ],
            [
                'titulo' => 'Triduo Pascual',
                'slug' => 'triduo-pascual-2025',
                'descripcion_corta' => 'Las celebraciones más importantes del año litúrgico: Jueves Santo, Viernes Santo y Vigilia Pascual.',
                'descripcion' => '<p>Te invitamos a vivir intensamente los días más santos del año cristiano.</p><ul><li>Jueves Santo: Misa de la Cena del Señor</li><li>Viernes Santo: Celebración de la Pasión</li><li>Sábado Santo: Solemne Vigilia Pascual</li></ul>',
                'fecha_inicio' => Carbon::create(2025, 4, 17),
                'fecha_fin' => Carbon::create(2025, 4, 19),
                'hora_inicio' => '19:00',
                'lugar' => 'Templo Principal',
                'categoria' => 'liturgico',
                'es_destacado' => true,
                'activo' => true,
            ],
            [
                'titulo' => 'Curso de Preparación Matrimonial',
                'slug' => 'curso-preparacion-matrimonial-mayo-2025',
                'descripcion_corta' => 'Formación para parejas que desean contraer matrimonio por la Iglesia.',
                'descripcion' => '<p>Curso obligatorio para las parejas que desean casarse por la Iglesia. Se abordan temas de comunicación, sexualidad, fe, economía familiar y más.</p>',
                'fecha_inicio' => Carbon::create(2025, 5, 3),
                'fecha_fin' => Carbon::create(2025, 5, 4),
                'hora_inicio' => '09:00',
                'hora_fin' => '14:00',
                'lugar' => 'Salón Parroquial',
                'categoria' => 'formacion',
                'es_destacado' => false,
                'activo' => true,
            ],
            [
                'titulo' => 'Fiesta Patronal - Nuestra Señora de la Encarnación',
                'slug' => 'fiesta-patronal-2025',
                'descripcion_corta' => 'Celebración solemne en honor a nuestra patrona, la Virgen de la Encarnación.',
                'descripcion' => '<p>Te invitamos a celebrar con alegría la fiesta de nuestra patrona. Habrá novenario previo, misa solemne, procesión y convivencia comunitaria.</p>',
                'fecha_inicio' => Carbon::create(2025, 3, 25),
                'hora_inicio' => '18:00',
                'lugar' => 'Templo Principal',
                'categoria' => 'liturgico',
                'es_destacado' => true,
                'activo' => true,
            ],
        ];

        foreach ($eventos as $evento) {
            Event::create($evento);
        }
    }
}
