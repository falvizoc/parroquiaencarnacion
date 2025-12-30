<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Idiomas soportados.
     */
    protected array $locales = ['es', 'en'];

    /**
     * Idioma predeterminado.
     */
    protected string $defaultLocale = 'es';

    /**
     * Maneja la solicitud entrante y establece el idioma.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $this->determinarIdioma($request);

        App::setLocale($locale);
        Session::put('locale', $locale);

        return $next($request);
    }

    /**
     * Determina el idioma a usar basado en múltiples fuentes.
     */
    protected function determinarIdioma(Request $request): string
    {
        // 1. Verificar si el idioma está en el segmento de URL
        $segmento = $request->segment(1);
        if (in_array($segmento, $this->locales)) {
            return $segmento;
        }

        // 2. Verificar si hay un idioma guardado en la sesión
        if (Session::has('locale') && in_array(Session::get('locale'), $this->locales)) {
            return Session::get('locale');
        }

        // 3. Detectar del encabezado Accept-Language del navegador
        $browserLocale = $request->getPreferredLanguage($this->locales);
        if ($browserLocale && in_array($browserLocale, $this->locales)) {
            return $browserLocale;
        }

        // 4. Usar el idioma predeterminado
        return $this->defaultLocale;
    }
}
