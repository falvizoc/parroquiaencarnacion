<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $noticias = [
            [
                'titulo' => 'Bienvenidos al Año Nuevo 2025',
                'slug' => 'bienvenidos-ano-nuevo-2025',
                'extracto' => 'La Parroquia Nuestra Señora de la Encarnación les desea un año lleno de bendiciones y prosperidad espiritual.',
                'contenido' => '<p>Querida comunidad parroquial,</p>
<p>Al iniciar este nuevo año 2025, queremos expresar nuestro más sincero agradecimiento por su fidelidad y compromiso con nuestra parroquia durante todo el año anterior.</p>
<p>Este nuevo año nos trae nuevas oportunidades para crecer en la fe, fortalecer nuestros lazos comunitarios y seguir trabajando juntos por el bien de nuestra comunidad.</p>
<h3>Propósitos para el Nuevo Año</h3>
<ul>
<li>Fortalecer la vida espiritual a través de la oración y los sacramentos</li>
<li>Participar activamente en las actividades parroquiales</li>
<li>Practicar la caridad con los más necesitados</li>
<li>Vivir en familia la fe católica</li>
</ul>
<p>Que la Virgen María, Nuestra Señora de la Encarnación, interceda por cada uno de ustedes y sus familias.</p>
<p><strong>¡Feliz y bendecido Año Nuevo!</strong></p>',
                'fecha_publicacion' => now()->subDays(2),
                'autor' => 'Padre Juan Carlos',
                'categoria' => 'parroquia',
                'es_destacado' => true,
                'activo' => true,
            ],
            [
                'titulo' => 'Calendario de Misas para Enero 2025',
                'slug' => 'calendario-misas-enero-2025',
                'extracto' => 'Consulta los horarios de misas y celebraciones especiales para este mes de enero.',
                'contenido' => '<p>Les compartimos el calendario de misas y celebraciones especiales para el mes de enero 2025:</p>
<h3>Horarios Regulares</h3>
<p>Los horarios de misas dominicales continúan sin cambios:</p>
<ul>
<li>7:00 AM - Misa de alba</li>
<li>10:00 AM - Misa familiar</li>
<li>12:30 PM - Misa solemne</li>
<li>7:00 PM - Misa vespertina</li>
</ul>
<h3>Celebraciones Especiales</h3>
<ul>
<li><strong>1 de enero:</strong> Solemnidad de Santa María, Madre de Dios</li>
<li><strong>6 de enero:</strong> Epifanía del Señor</li>
<li><strong>12 de enero:</strong> Bautismo del Señor</li>
</ul>
<p>Para más información sobre horarios de confesiones y otros sacramentos, visite nuestra sección de horarios o comuníquese a la oficina parroquial.</p>',
                'fecha_publicacion' => now()->subDays(5),
                'autor' => 'Secretaría Parroquial',
                'categoria' => 'parroquia',
                'es_destacado' => false,
                'activo' => true,
            ],
            [
                'titulo' => 'Mensaje del Papa Francisco para el Tiempo de Navidad',
                'slug' => 'mensaje-papa-francisco-navidad',
                'extracto' => 'El Santo Padre nos invita a vivir la Navidad con sencillez y generosidad hacia los más necesitados.',
                'contenido' => '<p>El Papa Francisco ha compartido un mensaje especial para este tiempo navideño, invitando a todos los fieles a vivir con espíritu de sencillez y solidaridad.</p>
<blockquote>
<p>"La Navidad nos recuerda que Dios eligió nacer en la pobreza, en la sencillez de un pesebre. Este es un mensaje poderoso para nuestro mundo que muchas veces busca la grandeza en lugares equivocados."</p>
</blockquote>
<h3>Llamado a la Solidaridad</h3>
<p>El Santo Padre enfatizó la importancia de recordar a quienes sufren:</p>
<ul>
<li>Los migrantes y refugiados</li>
<li>Los enfermos y ancianos solos</li>
<li>Las familias que enfrentan dificultades económicas</li>
<li>Los que viven en zonas de conflicto</li>
</ul>
<p>Pidió que nuestras celebraciones navideñas incluyan gestos concretos de amor hacia el prójimo.</p>',
                'fecha_publicacion' => now()->subDays(8),
                'autor' => 'Vatican News',
                'categoria' => 'papa',
                'es_destacado' => true,
                'activo' => true,
            ],
            [
                'titulo' => 'Exitosa Colecta Navideña 2024',
                'slug' => 'exitosa-colecta-navidena-2024',
                'extracto' => 'Gracias a la generosidad de nuestra comunidad, pudimos llevar alegría a más de 50 familias necesitadas.',
                'contenido' => '<p>Nos llena de alegría informar que la colecta navideña 2024 fue un rotundo éxito gracias a la generosidad de toda nuestra comunidad parroquial.</p>
<h3>Resultados</h3>
<ul>
<li>Más de 50 familias beneficiadas</li>
<li>200 despensas entregadas</li>
<li>100 juguetes para niños</li>
<li>Cobijas y ropa de invierno</li>
</ul>
<h3>Agradecimientos</h3>
<p>Queremos agradecer especialmente a:</p>
<ul>
<li>Todos los feligreses que donaron generosamente</li>
<li>Los voluntarios que ayudaron con la organización y distribución</li>
<li>El grupo de Cáritas Parroquial por su coordinación</li>
<li>Los comercios locales que se sumaron a la iniciativa</li>
</ul>
<p>Que Dios bendiga a cada persona que hizo posible esta obra de caridad.</p>',
                'fecha_publicacion' => now()->subDays(10),
                'autor' => 'Cáritas Parroquial',
                'categoria' => 'comunidad',
                'es_destacado' => false,
                'activo' => true,
            ],
            [
                'titulo' => 'Próximo Retiro Cuaresmal 2025',
                'slug' => 'proximo-retiro-cuaresmal-2025',
                'extracto' => 'Prepárate para la Cuaresma con nuestro retiro espiritual anual. Inscripciones abiertas.',
                'contenido' => '<p>Les invitamos a participar en nuestro Retiro Cuaresmal 2025, una oportunidad especial para preparar nuestros corazones para la Semana Santa.</p>
<h3>Detalles del Retiro</h3>
<ul>
<li><strong>Fecha:</strong> 15-16 de marzo de 2025</li>
<li><strong>Lugar:</strong> Casa de Retiros "San Ignacio"</li>
<li><strong>Tema:</strong> "Volver al Padre: El camino de la reconciliación"</li>
<li><strong>Cupo:</strong> 40 personas</li>
</ul>
<h3>Incluye</h3>
<ul>
<li>Hospedaje y alimentación</li>
<li>Material de trabajo</li>
<li>Dirección espiritual</li>
<li>Sacramento de la Reconciliación</li>
</ul>
<h3>Inscripciones</h3>
<p>Las inscripciones están abiertas en la oficina parroquial. Cuota de recuperación: $800 pesos. Hay becas disponibles para quienes lo necesiten.</p>
<p><strong>¡No dejes pasar esta oportunidad de encuentro con Dios!</strong></p>',
                'fecha_publicacion' => now()->subDays(3),
                'autor' => 'Equipo de Pastoral',
                'categoria' => 'parroquia',
                'es_destacado' => true,
                'activo' => true,
            ],
            [
                'titulo' => 'Diócesis de Tampico Celebra su Aniversario',
                'slug' => 'diocesis-tampico-aniversario',
                'extracto' => 'La Diócesis de Tampico celebra un año más de presencia evangelizadora en la región.',
                'contenido' => '<p>La Diócesis de Tampico celebra con alegría un aniversario más de su fundación, dando gracias a Dios por la fecunda labor evangelizadora en nuestra región.</p>
<h3>Historia</h3>
<p>La Diócesis de Tampico fue erigida canónicamente como parte del esfuerzo de la Iglesia por llevar el Evangelio a todas las regiones de México. A lo largo de los años, ha sido testigo del crecimiento de la fe católica en la región huasteca.</p>
<h3>Celebraciones</h3>
<p>Con motivo de este aniversario, se llevarán a cabo diversas actividades:</p>
<ul>
<li>Misa solemne en la Catedral</li>
<li>Peregrinación diocesana</li>
<li>Congreso de laicos</li>
<li>Jornada de oración por las vocaciones</li>
</ul>
<p>Invitamos a toda nuestra comunidad parroquial a unirse a estos festejos y dar gracias por el don de la fe.</p>',
                'fecha_publicacion' => now()->subDays(15),
                'autor' => 'Comunicación Diocesana',
                'categoria' => 'diocesis',
                'es_destacado' => false,
                'activo' => true,
            ],
        ];

        foreach ($noticias as $noticia) {
            News::create($noticia);
        }
    }
}
