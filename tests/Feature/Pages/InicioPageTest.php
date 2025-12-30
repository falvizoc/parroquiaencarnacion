<?php

namespace Tests\Feature\Pages;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InicioPageTest extends TestCase
{
    use RefreshDatabase;
    public function test_pagina_inicio_es_accesible(): void
    {
        $response = $this->get('/es');

        $response->assertStatus(200);
    }

    public function test_pagina_inicio_contiene_titulo(): void
    {
        $response = $this->get('/es');

        $response->assertSee('Parroquia');
    }

    public function test_redirige_idioma_ingles(): void
    {
        $response = $this->get('/en');

        $response->assertStatus(200);
    }

    public function test_redireccion_raiz_a_inicio(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/es');
    }
}
