<?php

namespace Tests\Feature\Pages;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NosotrosPageTest extends TestCase
{
    use RefreshDatabase;
    public function test_pagina_nosotros_es_accesible(): void
    {
        $response = $this->get('/es/nosotros');

        $response->assertStatus(200);
    }

    public function test_pagina_nosotros_contiene_mision(): void
    {
        $response = $this->get('/es/nosotros');

        $response->assertSee('Misión');
    }

    public function test_pagina_nosotros_contiene_faq(): void
    {
        $response = $this->get('/es/nosotros');

        // Verifica que contiene una pregunta del FAQ
        $response->assertSee('horarios de misa');
    }
}
