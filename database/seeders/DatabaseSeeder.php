<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario administrador para Filament
        User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@parroquiaencarnacion.org',
            'password' => bcrypt('password'),
        ]);

        $this->call([
            ChapelSeeder::class,
            PriestSeeder::class,
            MassScheduleSeeder::class,
            ParishGroupSeeder::class,
            EventSeeder::class,
            NewsSeeder::class,
        ]);
    }
}
