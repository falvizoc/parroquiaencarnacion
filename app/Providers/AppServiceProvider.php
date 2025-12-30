<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configurarRateLimiting();
    }

    /**
     * Configura rate limiting para proteger rutas críticas.
     */
    protected function configurarRateLimiting(): void
    {
        // Formularios públicos: 5 intentos por minuto
        RateLimiter::for('formularios', function (Request $request) {
            return Limit::perMinute(5)->by(
                $request->user()?->id ?: $request->ip()
            )->response(function (Request $request, array $headers) {
                return response()->json([
                    'mensaje' => 'Demasiados intentos. Por favor espere un momento.',
                ], 429, $headers);
            });
        });

        // Verificación de email: 3 intentos por minuto
        RateLimiter::for('verificacion', function (Request $request) {
            return Limit::perMinute(3)->by(
                $request->ip()
            )->response(function (Request $request, array $headers) {
                return response()->json([
                    'mensaje' => 'Demasiados intentos de verificación. Intente en un minuto.',
                ], 429, $headers);
            });
        });

        // Newsletter: 3 intentos por minuto
        RateLimiter::for('newsletter', function (Request $request) {
            return Limit::perMinute(3)->by(
                $request->ip()
            );
        });

        // Login admin (Filament): 5 intentos por minuto
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by(
                $request->input('email') . '|' . $request->ip()
            )->response(function (Request $request, array $headers) {
                return back()->withErrors([
                    'email' => 'Demasiados intentos de inicio de sesión. Intente en un minuto.',
                ]);
            });
        });

        // API general (si se implementa): 60 por minuto
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(
                $request->user()?->id ?: $request->ip()
            );
        });
    }
}
