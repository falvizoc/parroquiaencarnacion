<?php

namespace Database\Seeders;

use App\Models\Chapel;
use Illuminate\Database\Seeder;

class ChapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $capillas = [
            [
                'nombre' => 'Capilla San José',
                'slug' => 'capilla-san-jose',
                'descripcion' => 'La Capilla San José es un espacio de oración íntimo dedicado al patrono de la Iglesia Universal. Ubicada en la colonia Centro, sirve a la comunidad local con misas entre semana y servicios especiales.',
                'direccion' => 'Calle Juárez #123, Col. Centro, Tampico',
                'telefono' => '833-123-4567',
                'email' => 'sanjose@parroquiaencarnacion.org',
                'activo' => true,
                'orden' => 1,
            ],
            [
                'nombre' => 'Capilla Nuestra Señora de Guadalupe',
                'slug' => 'capilla-guadalupe',
                'descripcion' => 'Dedicada a la Virgen de Guadalupe, Patrona de México y las Américas. Esta capilla es un centro de devoción mariana donde se celebran especialmente las festividades guadalupanas.',
                'direccion' => 'Av. Hidalgo #456, Col. Altavista, Tampico',
                'telefono' => '833-234-5678',
                'email' => 'guadalupe@parroquiaencarnacion.org',
                'activo' => true,
                'orden' => 2,
            ],
            [
                'nombre' => 'Capilla del Sagrado Corazón',
                'slug' => 'capilla-sagrado-corazon',
                'descripcion' => 'La Capilla del Sagrado Corazón de Jesús es un lugar de adoración eucarística y encuentro con el amor de Cristo. Ofrece horarios de misa adaptados a la comunidad de la zona sur.',
                'direccion' => 'Blvd. López Mateos #789, Col. Las Flores, Tampico',
                'telefono' => '833-345-6789',
                'email' => 'sagradocorazon@parroquiaencarnacion.org',
                'activo' => true,
                'orden' => 3,
            ],
        ];

        foreach ($capillas as $capilla) {
            Chapel::create($capilla);
        }
    }
}
