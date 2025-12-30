<?php

namespace Tests\Feature\Pages;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventosPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_pagina_eventos_es_accesible(): void
    {
        $response = $this->get('/es/eventos');

        $response->assertStatus(200);
    }

    public function test_muestra_eventos_proximos(): void
    {
        $evento = Event::factory()->create([
            'titulo' => 'Evento futuro visible',
            'fecha_inicio' => now()->addDays(5),
            'activo' => true,
        ]);

        $response = $this->get('/es/eventos');

        $response->assertSee('Evento futuro visible');
    }

    public function test_pagina_detalle_evento_es_accesible(): void
    {
        $evento = Event::factory()->create([
            'titulo' => 'Evento detalle test',
            'slug' => 'evento-detalle-test',
            'fecha_inicio' => now()->addDays(5),
            'activo' => true,
        ]);

        $response = $this->get('/es/eventos/evento-detalle-test');

        $response->assertStatus(200);
        $response->assertSee('Evento detalle test');
    }
}
