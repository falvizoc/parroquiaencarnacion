<?php

namespace Tests\Feature\Pages;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HorariosPageTest extends TestCase
{
    use RefreshDatabase;
    public function test_pagina_horarios_es_accesible(): void
    {
        $response = $this->get('/es/horarios');

        $response->assertStatus(200);
    }

    public function test_pagina_horarios_contiene_seccion_misas(): void
    {
        $response = $this->get('/es/horarios');

        $response->assertSee('Misa');
    }
}
