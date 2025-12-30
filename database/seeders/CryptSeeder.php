<?php

namespace Database\Seeders;

use App\Models\CryptCampaign;
use App\Models\CryptInfo;
use Illuminate\Database\Seeder;

class CryptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Información general de criptas
        CryptInfo::create([
            'titulo' => 'Zona de Criptas',
            'subtitulo' => 'Un lugar de paz y recuerdo eterno',
            'descripcion' => '<p>Nuestra parroquia cuenta con una zona de criptas donde los fieles pueden adquirir un espacio para el descanso eterno de sus seres queridos.</p><p>Las criptas se encuentran en un ambiente de paz y recogimiento, con acceso permanente para que los familiares puedan visitar y orar por sus difuntos.</p><p>Contamos con diferentes opciones y planes de pago. Para más información, comuníquese con la oficina parroquial.</p>',
            'descripcion_corta' => 'Nuestra parroquia cuenta con una zona de criptas donde los fieles pueden adquirir un espacio para el descanso eterno de sus seres queridos, en un ambiente de paz y recogimiento.',
            'telefono_contacto' => '(833) 123-4567',
            'email_contacto' => 'criptas@parroquiaencarnaciontampico.org',
            'horario_atencion' => 'Lunes a Viernes 9:00 - 17:00, Sábados 9:00 - 13:00',
            'mostrar_en_inicio' => true,
            'activo' => true,
        ]);

        // Campaña de ejemplo (mantenimiento anual)
        CryptCampaign::create([
            'titulo' => 'Campaña de Mantenimiento Anual 2025',
            'descripcion' => 'Aprovecha el precio especial por mantenimiento anual de criptas. Incluye limpieza, conservación y cuidado de espacios comunes. Vigente hasta el 31 de enero.',
            'color_fondo' => '#b45309', // amber-700
            'fecha_inicio' => '2024-12-01',
            'fecha_fin' => '2025-01-31',
            'texto_boton' => 'Más información',
            'url_boton' => '/es/contacto',
            'activo' => true,
        ]);
    }
}
