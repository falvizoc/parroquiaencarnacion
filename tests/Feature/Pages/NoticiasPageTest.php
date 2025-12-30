<?php

namespace Tests\Feature\Pages;

use App\Models\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NoticiasPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_pagina_noticias_es_accesible(): void
    {
        $response = $this->get('/es/noticias');

        $response->assertStatus(200);
    }

    public function test_muestra_noticias_activas(): void
    {
        $noticia = News::factory()->create([
            'titulo' => 'Noticia de prueba visible',
            'activo' => true,
            'fecha_publicacion' => now()->subDay(),
        ]);

        $response = $this->get('/es/noticias');

        $response->assertSee('Noticia de prueba visible');
    }

    public function test_no_muestra_noticias_inactivas(): void
    {
        $noticia = News::factory()->create([
            'titulo' => 'Noticia oculta',
            'activo' => false,
        ]);

        $response = $this->get('/es/noticias');

        $response->assertDontSee('Noticia oculta');
    }

    public function test_pagina_detalle_noticia_es_accesible(): void
    {
        $noticia = News::factory()->create([
            'titulo' => 'Noticia detalle test',
            'slug' => 'noticia-detalle-test',
            'activo' => true,
            'fecha_publicacion' => now()->subDay(),
        ]);

        $response = $this->get('/es/noticias/noticia-detalle-test');

        $response->assertStatus(200);
        $response->assertSee('Noticia detalle test');
    }
}
