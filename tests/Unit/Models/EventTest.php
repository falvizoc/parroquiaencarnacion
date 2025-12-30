<?php

namespace Tests\Unit\Models;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_crear_evento(): void
    {
        $evento = Event::factory()->create([
            'titulo' => 'Evento de prueba',
            'slug' => 'evento-de-prueba',
            'fecha_inicio' => now()->addDays(5),
            'activo' => true,
        ]);

        $this->assertDatabaseHas('events', [
            'titulo' => 'Evento de prueba',
            'slug' => 'evento-de-prueba',
        ]);
    }

    public function test_scope_proximos_filtra_eventos_futuros(): void
    {
        Event::factory()->create([
            'fecha_inicio' => now()->addDays(5),
            'activo' => true,
        ]);
        Event::factory()->create([
            'fecha_inicio' => now()->subDays(5),
            'activo' => true,
        ]);

        $proximos = Event::proximos()->count();

        $this->assertEquals(1, $proximos);
    }

    public function test_scope_pasados_filtra_eventos_anteriores(): void
    {
        Event::factory()->create([
            'fecha_inicio' => now()->addDays(5),
            'activo' => true,
        ]);
        Event::factory()->create([
            'fecha_inicio' => now()->subDays(5),
            'activo' => true,
        ]);

        $pasados = Event::pasados()->count();

        $this->assertEquals(1, $pasados);
    }

    public function test_accessor_fecha_formateada(): void
    {
        $evento = Event::factory()->create([
            'fecha_inicio' => '2025-12-25 10:00:00',
        ]);

        $this->assertNotEmpty($evento->fecha_formateada);
        $this->assertIsString($evento->fecha_formateada);
    }
}
