<?php

namespace Tests\Integration;

use App\Services\SeoService;
use Tests\TestCase;

class SeoServiceTest extends TestCase
{
    protected SeoService $seo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seo = app(SeoService::class);
    }

    public function test_puede_establecer_y_obtener_titulo(): void
    {
        $this->seo->setTitulo('Mi Título de Prueba');

        $this->assertEquals('Mi Título de Prueba', $this->seo->getTitulo());
    }

    public function test_puede_establecer_y_obtener_descripcion(): void
    {
        $this->seo->setDescripcion('Esta es una descripción de prueba para el SEO.');

        $this->assertStringContainsString('descripción de prueba', $this->seo->getDescripcion());
    }

    public function test_puede_establecer_y_obtener_imagen(): void
    {
        $this->seo->setImagen('images/test.jpg');

        $this->assertStringContainsString('images/test.jpg', $this->seo->getImagen());
    }

    public function test_puede_generar_schema_articulo(): void
    {
        $this->seo->schemaArticulo([
            'titulo' => 'Artículo de Prueba',
            'descripcion' => 'Descripción del artículo',
            'fecha_publicacion' => now(),
            'fecha_modificacion' => now(),
        ]);

        $schemas = $this->seo->getSchemaExtra();
        $this->assertNotEmpty($schemas);

        $schema = $schemas[0];
        $this->assertEquals('Article', $schema['@type']);
        $this->assertEquals('Artículo de Prueba', $schema['headline']);
    }

    public function test_puede_generar_schema_evento(): void
    {
        $this->seo->schemaEvento([
            'nombre' => 'Evento de Prueba',
            'descripcion' => 'Descripción del evento',
            'fecha_inicio' => now()->addDays(5),
            'ubicacion' => 'Templo Parroquial',
        ]);

        $schemas = $this->seo->getSchemaExtra();
        $this->assertNotEmpty($schemas);

        $schema = $schemas[0];
        $this->assertEquals('Event', $schema['@type']);
        $this->assertEquals('Evento de Prueba', $schema['name']);
    }

    public function test_puede_agregar_breadcrumbs(): void
    {
        $this->seo->setBreadcrumbs([
            'Inicio' => route('inicio', ['locale' => 'es']),
            'Noticias' => route('noticias.index', ['locale' => 'es']),
        ]);

        $breadcrumbs = $this->seo->schemaBreadcrumbs();

        $this->assertNotNull($breadcrumbs);
        $this->assertEquals('BreadcrumbList', $breadcrumbs['@type']);
        $this->assertCount(2, $breadcrumbs['itemListElement']);
    }

    public function test_tipo_por_defecto_es_website(): void
    {
        $this->assertEquals('website', $this->seo->getTipo());
    }

    public function test_puede_cambiar_tipo(): void
    {
        $this->seo->setTipo('article');

        $this->assertEquals('article', $this->seo->getTipo());
    }

    public function test_descripcion_se_trunca_a_160_caracteres(): void
    {
        $descripcionLarga = str_repeat('palabra ', 50);
        $this->seo->setDescripcion($descripcionLarga);

        $descripcion = $this->seo->getDescripcion();
        $this->assertLessThanOrEqual(163, strlen($descripcion)); // 160 + "..."
    }
}
