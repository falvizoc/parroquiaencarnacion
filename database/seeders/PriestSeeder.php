<?php

namespace Database\Seeders;

use App\Models\Priest;
use Illuminate\Database\Seeder;

class PriestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sacerdotes = [
            [
                'nombre' => 'Juan Carlos Martínez López',
                'slug' => 'juan-carlos-martinez',
                'cargo' => 'parroco',
                'titulo' => 'pbro',
                'mensaje' => '<p>Queridos hermanos y hermanas en Cristo,</p>
<p>Es un privilegio servir como párroco de esta hermosa comunidad de fe. La Parroquia Nuestra Señora de la Encarnación es un lugar donde el amor de Dios se hace presente en cada celebración, en cada encuentro, en cada momento de oración.</p>
<p>Les invito a participar activamente en la vida de nuestra parroquia. Juntos, como familia de fe, podemos crecer en santidad y ser testimonio del Evangelio en nuestro entorno.</p>
<p>Que la Virgen María, bajo su advocación de la Encarnación, nos acompañe y proteja siempre.</p>
<p><em>Con afecto pastoral,<br>Pbro. Juan Carlos Martínez López</em></p>',
                'biografia' => 'Ordenado sacerdote en 2005 por la Diócesis de Tampico. Ha servido en diversas parroquias de la diócesis y fue designado párroco de la Parroquia Nuestra Señora de la Encarnación en 2020. Es licenciado en Teología por la Universidad Pontificia de México.',
                'email' => 'parroco@parroquiaencarnacion.org',
                'telefono' => '833-100-0001',
                'fecha_ordenacion' => '2005-06-29',
                'fecha_asignacion' => '2020-08-15',
                'activo' => true,
                'orden' => 0,
            ],
            [
                'nombre' => 'Roberto García Hernández',
                'slug' => 'roberto-garcia',
                'cargo' => 'vicario',
                'titulo' => 'pbro',
                'mensaje' => '<p>Hermanos en Cristo,</p>
<p>Como vicario parroquial, mi misión es acompañarles en su camino de fe. Estoy especialmente dedicado a la pastoral juvenil y a la formación de los grupos parroquiales.</p>
<p>Los jóvenes son el presente y el futuro de la Iglesia. Por eso, trabajamos para ofrecerles espacios de encuentro con Cristo y de crecimiento personal.</p>
<p>¡Cuenten conmigo!</p>',
                'biografia' => 'Ordenado en 2015. Especializado en pastoral juvenil y catequesis. Fue asignado a esta parroquia en 2022 para apoyar los programas de formación y acompañamiento a los jóvenes de la comunidad.',
                'email' => 'vicario@parroquiaencarnacion.org',
                'telefono' => '833-100-0002',
                'fecha_ordenacion' => '2015-05-16',
                'fecha_asignacion' => '2022-01-15',
                'activo' => true,
                'orden' => 1,
            ],
        ];

        foreach ($sacerdotes as $sacerdote) {
            Priest::create($sacerdote);
        }
    }
}
