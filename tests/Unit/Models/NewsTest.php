<?php

namespace Tests\Unit\Models;

use App\Models\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_crear_noticia(): void
    {
        $noticia = News::factory()->create([
            'titulo' => 'Noticia de prueba',
            'slug' => 'noticia-de-prueba',
            'contenido' => 'Contenido de la noticia de prueba.',
            'categoria' => 'parroquia',
            'activo' => true,
            'es_destacado' => false,
        ]);

        $this->assertDatabaseHas('news', [
            'titulo' => 'Noticia de prueba',
            'slug' => 'noticia-de-prueba',
        ]);
    }

    public function test_scope_activo_filtra_correctamente(): void
    {
        News::factory()->create(['activo' => true]);
        News::factory()->create(['activo' => false]);

        $activas = News::activo()->count();
        $todas = News::count();

        $this->assertEquals(1, $activas);
        $this->assertEquals(2, $todas);
    }

    public function test_scope_publicado_filtra_por_fecha(): void
    {
        News::factory()->create([
            'fecha_publicacion' => now()->subDay(),
            'activo' => true,
        ]);
        News::factory()->create([
            'fecha_publicacion' => now()->addDay(),
            'activo' => true,
        ]);

        $publicadas = News::publicado()->count();

        $this->assertEquals(1, $publicadas);
    }

    public function test_accessor_nombre_categoria(): void
    {
        $noticia = News::factory()->create(['categoria' => 'parroquia']);

        $this->assertEquals('Parroquia', $noticia->nombre_categoria);
    }

    public function test_accessor_tiempo_lectura(): void
    {
        $contenidoCorto = str_repeat('palabra ', 100);
        $contenidoLargo = str_repeat('palabra ', 500);

        $noticiaCorta = News::factory()->create(['contenido' => $contenidoCorto]);
        $noticiaLarga = News::factory()->create(['contenido' => $contenidoLargo]);

        $this->assertGreaterThan(0, $noticiaCorta->tiempo_lectura);
        $this->assertGreaterThan($noticiaCorta->tiempo_lectura, $noticiaLarga->tiempo_lectura);
    }
}
