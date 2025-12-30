<?php

namespace App\Http\Controllers;

use App\Models\Chapel;
use App\Models\Event;
use App\Models\News;
use App\Models\ParishGroup;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = $this->generarUrls();

        $content = view('seo.sitemap', compact('urls'))->render();

        return response($content, 200)
            ->header('Content-Type', 'application/xml');
    }

    protected function generarUrls(): array
    {
        $urls = [];
        $locales = ['es', 'en'];

        // Páginas estáticas
        $paginasEstaticas = [
            'inicio' => ['priority' => '1.0', 'changefreq' => 'daily'],
            'horarios' => ['priority' => '0.9', 'changefreq' => 'weekly'],
            'noticias.index' => ['priority' => '0.8', 'changefreq' => 'daily'],
            'eventos.index' => ['priority' => '0.8', 'changefreq' => 'daily'],
            'grupos.index' => ['priority' => '0.7', 'changefreq' => 'weekly'],
            'capillas.index' => ['priority' => '0.7', 'changefreq' => 'monthly'],
            'sacerdotes' => ['priority' => '0.6', 'changefreq' => 'monthly'],
            'adoracion' => ['priority' => '0.6', 'changefreq' => 'monthly'],
            'contacto' => ['priority' => '0.5', 'changefreq' => 'monthly'],
            'registro' => ['priority' => '0.5', 'changefreq' => 'monthly'],
        ];

        foreach ($locales as $locale) {
            foreach ($paginasEstaticas as $routeName => $config) {
                $urls[] = [
                    'loc' => route($routeName, ['locale' => $locale]),
                    'lastmod' => now()->toW3cString(),
                    'changefreq' => $config['changefreq'],
                    'priority' => $config['priority'],
                ];
            }
        }

        // Noticias
        $noticias = News::activo()->publicado()->get();
        foreach ($noticias as $noticia) {
            foreach ($locales as $locale) {
                $urls[] = [
                    'loc' => route('noticias.detalle', ['locale' => $locale, 'slug' => $noticia->slug]),
                    'lastmod' => $noticia->updated_at->toW3cString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.6',
                ];
            }
        }

        // Eventos
        $eventos = Event::activo()->get();
        foreach ($eventos as $evento) {
            foreach ($locales as $locale) {
                $urls[] = [
                    'loc' => route('eventos.detalle', ['locale' => $locale, 'slug' => $evento->slug]),
                    'lastmod' => $evento->updated_at->toW3cString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.6',
                ];
            }
        }

        // Grupos parroquiales
        $grupos = ParishGroup::activo()->get();
        foreach ($grupos as $grupo) {
            foreach ($locales as $locale) {
                $urls[] = [
                    'loc' => route('grupos.detalle', ['locale' => $locale, 'slug' => $grupo->slug]),
                    'lastmod' => $grupo->updated_at->toW3cString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.5',
                ];
            }
        }

        // Capillas
        $capillas = Chapel::activo()->get();
        foreach ($capillas as $capilla) {
            foreach ($locales as $locale) {
                $urls[] = [
                    'loc' => route('capillas.detalle', ['locale' => $locale, 'slug' => $capilla->slug]),
                    'lastmod' => $capilla->updated_at->toW3cString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.5',
                ];
            }
        }

        return $urls;
    }
}
