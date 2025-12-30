<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CacheControl
{
    /**
     * Agrega headers de caché para mejorar rendimiento.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Solo aplicar caché en producción y para respuestas exitosas
        if (!app()->isProduction() || !$response->isSuccessful()) {
            return $response;
        }

        // No cachear respuestas de admin o livewire
        $path = $request->path();
        if (str_starts_with($path, 'admin') || str_starts_with($path, 'livewire')) {
            return $response->withHeaders([
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
            ]);
        }

        // Páginas dinámicas: caché corto con revalidación
        $cacheTime = $this->obtenerTiempoCache($path);

        $response->withHeaders([
            'Cache-Control' => "public, max-age={$cacheTime}, stale-while-revalidate=60",
            'Vary' => 'Accept-Encoding, Accept-Language',
        ]);

        // ETag para validación de caché
        $etag = md5($response->getContent());
        $response->setEtag($etag);

        return $response;
    }

    /**
     * Determina el tiempo de caché según el tipo de página.
     */
    protected function obtenerTiempoCache(string $path): int
    {
        // Archivos estáticos SEO: caché largo
        if (in_array($path, ['sitemap.xml', 'robots.txt', 'llms.txt'])) {
            return 86400; // 24 horas
        }

        // Página de inicio: caché corto
        if ($path === 'es' || $path === 'en' || $path === '') {
            return 300; // 5 minutos
        }

        // Horarios: caché medio
        if (str_contains($path, 'horarios')) {
            return 3600; // 1 hora
        }

        // Noticias y eventos: caché corto
        if (str_contains($path, 'noticias') || str_contains($path, 'eventos')) {
            return 600; // 10 minutos
        }

        // Páginas estáticas: caché largo
        if (str_contains($path, 'nosotros') || str_contains($path, 'adoracion')) {
            return 86400; // 24 horas
        }

        // Por defecto: 30 minutos
        return 1800;
    }
}
