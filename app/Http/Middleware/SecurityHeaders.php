<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Headers de seguridad recomendados por OWASP.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Prevenir MIME type sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Prevenir clickjacking - permitir solo mismo origen
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Protección XSS (legacy, pero aún útil para navegadores antiguos)
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Política de referrer - enviar origen completo solo al mismo sitio
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Permissions Policy - restringir APIs del navegador
        $response->headers->set('Permissions-Policy', $this->obtenerPermissionsPolicy());

        // Content Security Policy
        $response->headers->set('Content-Security-Policy', $this->obtenerCSP($request));

        // HSTS - solo en producción con HTTPS
        if (app()->isProduction() && $request->secure()) {
            // max-age de 1 año, incluir subdominios
            $response->headers->set(
                'Strict-Transport-Security',
                'max-age=31536000; includeSubDomains'
            );
        }

        return $response;
    }

    /**
     * Genera la Content Security Policy.
     */
    protected function obtenerCSP(Request $request): string
    {
        $nonce = $this->generarNonce();

        // Dominios permitidos
        $self = "'self'";
        $unsafeInline = "'unsafe-inline'"; // Necesario para Livewire/Filament
        $unsafeEval = "'unsafe-eval'"; // Necesario para algunos scripts de terceros

        // Dominios de terceros confiables
        $googleFonts = 'https://fonts.googleapis.com https://fonts.gstatic.com https://fonts.bunny.net';
        $googleAnalytics = 'https://www.googletagmanager.com https://www.google-analytics.com https://analytics.google.com';
        $googleMaps = 'https://maps.googleapis.com https://maps.gstatic.com https://*.google.com';
        $facebook = 'https://connect.facebook.net https://www.facebook.com https://graph.facebook.com';
        $youtube = 'https://www.youtube.com https://www.youtube-nocookie.com';

        // Vite dev server en desarrollo
        $vite = app()->isLocal() ? 'http://localhost:5173 http://127.0.0.1:5173 ws://localhost:5173 ws://127.0.0.1:5173' : '';

        $directives = [
            // Fuentes por defecto
            "default-src {$self} {$vite}",

            // Scripts - permitir inline para Livewire/Alpine
            "script-src {$self} {$unsafeInline} {$unsafeEval} {$googleAnalytics} {$facebook} {$vite}",

            // Estilos - permitir inline para Tailwind/Livewire
            "style-src {$self} {$unsafeInline} {$googleFonts} {$vite}",

            // Imágenes
            "img-src {$self} data: blob: https: {$googleAnalytics} {$facebook}",

            // Fuentes
            "font-src {$self} data: {$googleFonts}",

            // Conexiones (AJAX, WebSocket, Vite HMR)
            "connect-src {$self} {$googleAnalytics} {$facebook} wss: {$vite}",

            // Frames (YouTube, Google Maps, Facebook)
            "frame-src {$self} {$youtube} {$googleMaps} {$facebook}",

            // Frames ancestros - prevenir embedding malicioso
            "frame-ancestors {$self}",

            // Formularios - solo mismo origen
            "form-action {$self}",

            // Base URI
            "base-uri {$self}",

            // Object/embed
            "object-src 'none'",

            // Upgrade insecure requests en producción
            app()->isProduction() ? 'upgrade-insecure-requests' : '',
        ];

        return implode('; ', array_filter($directives));
    }

    /**
     * Genera la Permissions Policy para restringir APIs del navegador.
     */
    protected function obtenerPermissionsPolicy(): string
    {
        $policies = [
            'accelerometer' => '()',
            'camera' => '()',
            'geolocation' => '(self)',  // Permitir para mapa de ubicación
            'gyroscope' => '()',
            'magnetometer' => '()',
            'microphone' => '()',
            'payment' => '()',           // Cambiar a (self) si implementan pagos
            'usb' => '()',
        ];

        return collect($policies)
            ->map(fn($value, $key) => "{$key}={$value}")
            ->implode(', ');
    }

    /**
     * Genera un nonce para CSP (para uso futuro con scripts inline).
     */
    protected function generarNonce(): string
    {
        if (!session()->has('csp_nonce')) {
            session(['csp_nonce' => base64_encode(random_bytes(16))]);
        }

        return session('csp_nonce');
    }
}
