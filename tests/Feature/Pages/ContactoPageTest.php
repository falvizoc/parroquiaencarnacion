<?php

namespace Tests\Feature\Pages;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactoPageTest extends TestCase
{
    use RefreshDatabase;
    public function test_pagina_contacto_es_accesible(): void
    {
        $response = $this->get('/es/contacto');

        $response->assertStatus(200);
    }

    public function test_pagina_contacto_contiene_formulario(): void
    {
        $response = $this->get('/es/contacto');

        $response->assertSee('Contacto');
    }
}
