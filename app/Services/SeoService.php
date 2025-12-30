<?php

namespace App\Services;

use Illuminate\Support\Facades\View;

class SeoService
{
    protected string $titulo = '';
    protected string $descripcion = '';
    protected string $imagen = '';
    protected string $tipo = 'website';
    protected array $breadcrumbs = [];
    protected array $schemaExtra = [];

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;
        return $this;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = \Str::limit(strip_tags($descripcion), 160);
        return $this;
    }

    public function setImagen(?string $imagen): self
    {
        $this->imagen = $imagen ?: '';
        return $this;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;
        return $this;
    }

    public function setBreadcrumbs(array $breadcrumbs): self
    {
        $this->breadcrumbs = $breadcrumbs;
        return $this;
    }

    public function addSchema(array $schema): self
    {
        $this->schemaExtra[] = $schema;
        return $this;
    }

    public function getTitulo(): string
    {
        return $this->titulo ?: __('general.seo.default_title');
    }

    public function getDescripcion(): string
    {
        return $this->descripcion ?: __('general.seo.default_description');
    }

    public function getImagen(): string
    {
        if ($this->imagen) {
            return str_starts_with($this->imagen, 'http')
                ? $this->imagen
                : asset('storage/' . $this->imagen);
        }
        return asset('images/og-default.jpg');
    }

    public function getTipo(): string
    {
        return $this->tipo;
    }

    public function getBreadcrumbs(): array
    {
        return $this->breadcrumbs;
    }

    public function getSchemaExtra(): array
    {
        return $this->schemaExtra;
    }

    /**
     * Genera Schema.org para un artículo/noticia
     */
    public function schemaArticulo(array $datos): self
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $datos['titulo'] ?? '',
            'description' => $datos['descripcion'] ?? '',
            'image' => $datos['imagen'] ?? '',
            'datePublished' => $datos['fecha_publicacion'] ?? '',
            'dateModified' => $datos['fecha_modificacion'] ?? $datos['fecha_publicacion'] ?? '',
            'author' => [
                '@type' => 'Organization',
                'name' => __('general.site.name'),
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => __('general.site.name'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('images/logo.png'),
                ],
            ],
        ];

        return $this->addSchema($schema);
    }

    /**
     * Genera Schema.org para un evento
     */
    public function schemaEvento(array $datos): self
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Event',
            'name' => $datos['nombre'] ?? '',
            'description' => $datos['descripcion'] ?? '',
            'startDate' => $datos['fecha_inicio'] ?? '',
            'endDate' => $datos['fecha_fin'] ?? $datos['fecha_inicio'] ?? '',
            'location' => [
                '@type' => 'Place',
                'name' => $datos['ubicacion'] ?? __('general.site.name'),
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressLocality' => 'Tampico',
                    'addressRegion' => 'Tamaulipas',
                    'addressCountry' => 'MX',
                ],
            ],
            'organizer' => [
                '@type' => 'Organization',
                'name' => __('general.site.name'),
            ],
            'eventStatus' => 'https://schema.org/EventScheduled',
            'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
        ];

        if (!empty($datos['imagen'])) {
            $schema['image'] = $datos['imagen'];
        }

        return $this->addSchema($schema);
    }

    /**
     * Genera Schema.org BreadcrumbList
     */
    public function schemaBreadcrumbs(): ?array
    {
        if (empty($this->breadcrumbs)) {
            return null;
        }

        $items = [];
        $position = 1;

        foreach ($this->breadcrumbs as $nombre => $url) {
            $items[] = [
                '@type' => 'ListItem',
                'position' => $position,
                'name' => $nombre,
                'item' => $url ?: url()->current(),
            ];
            $position++;
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items,
        ];
    }
}
