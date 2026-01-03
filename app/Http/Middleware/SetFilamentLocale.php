<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetFilamentLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Obtener el locale guardado en sesión para el admin
        $locale = session('filament_locale', 'es');

        // Validar que sea un locale permitido
        if (!in_array($locale, ['es', 'en'])) {
            $locale = 'es';
        }

        // Aplicar el locale a la aplicación
        app()->setLocale($locale);

        return $next($request);
    }
}
