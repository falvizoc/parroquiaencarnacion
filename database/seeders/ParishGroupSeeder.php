<?php

namespace Database\Seeders;

use App\Models\ParishGroup;
use Illuminate\Database\Seeder;

class ParishGroupSeeder extends Seeder
{
    public function run(): void
    {
        $grupos = [
            [
                'nombre' => 'Coro Parroquial',
                'slug' => 'coro-parroquial',
                'descripcion_corta' => 'Ministerio de música litúrgica que anima las celebraciones eucarísticas con cantos y alabanzas.',
                'descripcion' => '<p>El Coro Parroquial está dedicado a enriquecer nuestras celebraciones litúrgicas a través de la música sacra. Buscamos personas con vocación musical que deseen servir a Dios y a la comunidad.</p><p>No se requiere experiencia previa, solo disposición para aprender y servir.</p>',
                'dia_reunion' => 6, // Sábado
                'hora_reunion' => '17:00',
                'lugar_reunion' => 'Salón Parroquial',
                'coordinador_nombre' => 'María González',
                'activo' => true,
                'orden' => 1,
            ],
            [
                'nombre' => 'Grupo de Oración',
                'slug' => 'grupo-oracion',
                'descripcion_corta' => 'Comunidad dedicada a la oración carismática, alabanza y adoración al Santísimo.',
                'descripcion' => '<p>Somos una comunidad que se reúne semanalmente para orar, alabar y adorar a Dios. Experimentamos la presencia del Espíritu Santo a través de la oración comunitaria.</p><p>Todos son bienvenidos a unirse a nosotros en este camino de fe.</p>',
                'dia_reunion' => 3, // Miércoles
                'hora_reunion' => '19:30',
                'lugar_reunion' => 'Capilla de Adoración',
                'coordinador_nombre' => 'Roberto Martínez',
                'activo' => true,
                'orden' => 2,
            ],
            [
                'nombre' => 'Legión de María',
                'slug' => 'legion-de-maria',
                'descripcion_corta' => 'Asociación de fieles católicos que sirven a la Iglesia y al prójimo bajo la guía de María Santísima.',
                'descripcion' => '<p>La Legión de María es una asociación internacional de fieles católicos que, con la sanción de la Iglesia y bajo la poderosa dirección de María Inmaculada, se han organizado para el servicio de la Iglesia.</p><p>Realizamos visitas a enfermos, prisiones y evangelización.</p>',
                'dia_reunion' => 1, // Lunes
                'hora_reunion' => '18:00',
                'lugar_reunion' => 'Salón San José',
                'coordinador_nombre' => 'Carmen López',
                'activo' => true,
                'orden' => 3,
            ],
            [
                'nombre' => 'Catequesis Infantil',
                'slug' => 'catequesis-infantil',
                'descripcion_corta' => 'Formación en la fe para niños que se preparan para recibir los sacramentos de la iniciación cristiana.',
                'descripcion' => '<p>Programa de formación catequética para niños desde los 7 años. Preparamos a los pequeños para recibir la Primera Comunión y la Confirmación.</p><p>Las clases se imparten en un ambiente de amor y alegría, utilizando métodos pedagógicos adaptados a cada edad.</p>',
                'dia_reunion' => 6, // Sábado
                'hora_reunion' => '10:00',
                'lugar_reunion' => 'Aulas de Catequesis',
                'coordinador_nombre' => 'Ana Rodríguez',
                'activo' => true,
                'orden' => 4,
            ],
            [
                'nombre' => 'Grupo de Jóvenes',
                'slug' => 'grupo-jovenes',
                'descripcion_corta' => 'Espacio de encuentro, formación y diversión para jóvenes que buscan crecer en su fe.',
                'descripcion' => '<p>Somos jóvenes que buscamos vivir nuestra fe de manera auténtica y alegre. Realizamos actividades de formación, convivencia, retiros y servicio comunitario.</p><p>Si tienes entre 15 y 30 años, ¡te esperamos!</p>',
                'dia_reunion' => 5, // Viernes
                'hora_reunion' => '19:00',
                'lugar_reunion' => 'Salón de Jóvenes',
                'coordinador_nombre' => 'Luis Hernández',
                'activo' => true,
                'orden' => 5,
            ],
            [
                'nombre' => 'Ministros Extraordinarios de la Comunión',
                'slug' => 'ministros-comunion',
                'descripcion_corta' => 'Laicos que llevan la Eucaristía a los enfermos y colaboran en la distribución de la comunión.',
                'descripcion' => '<p>Los Ministros Extraordinarios de la Sagrada Comunión son laicos que, debidamente formados y autorizados, colaboran en la distribución de la Eucaristía durante la Misa y llevan la comunión a los enfermos que no pueden asistir al templo.</p>',
                'dia_reunion' => 2, // Martes
                'hora_reunion' => '18:30',
                'lugar_reunion' => 'Sacristía',
                'coordinador_nombre' => 'Pedro Sánchez',
                'activo' => true,
                'orden' => 6,
            ],
        ];

        foreach ($grupos as $grupo) {
            ParishGroup::create($grupo);
        }
    }
}
