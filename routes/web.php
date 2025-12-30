<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas Web
|--------------------------------------------------------------------------
|
| Rutas públicas del sitio web de la Parroquia Nuestra Señora de la Encarnación.
| Las rutas soportan prefijo de idioma opcional (es/en).
|
*/

// Ruta raíz - redirige al idioma predeterminado
Route::get('/', function () {
    return redirect('/es');
});

// Cambio de idioma
Route::get('/idioma/{locale}', function (string $locale) {
    if (in_array($locale, ['es', 'en'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('cambiar.idioma');

// Rutas con prefijo de idioma
Route::prefix('{locale}')
    ->where(['locale' => 'es|en'])
    ->group(function () {
        // Página de inicio
        Route::get('/', function () {
            return view('pages.inicio');
        })->name('inicio');

        // Horarios de misa
        Route::get('/horarios', function () {
            return view('pages.horarios');
        })->name('horarios');

        // Noticias
        Route::get('/noticias', function () {
            return view('pages.noticias.index');
        })->name('noticias.index');

        Route::get('/noticias/{slug}', function (string $locale, string $slug) {
            return view('pages.noticias.detalle', compact('slug'));
        })->name('noticias.detalle');

        // Eventos
        Route::get('/eventos', function () {
            return view('pages.eventos.index');
        })->name('eventos.index');

        Route::get('/eventos/{slug}', function (string $locale, string $slug) {
            return view('pages.eventos.detalle', compact('slug'));
        })->name('eventos.detalle');

        // Grupos parroquiales
        Route::get('/grupos', function () {
            return view('pages.grupos.index');
        })->name('grupos.index');

        Route::get('/grupos/{slug}', function (string $locale, string $slug) {
            return view('pages.grupos.detalle', compact('slug'));
        })->name('grupos.detalle');

        // Adoración perpetua
        Route::get('/adoracion', function () {
            return view('pages.adoracion');
        })->name('adoracion');

        // Contacto
        Route::get('/contacto', function () {
            return view('pages.contacto');
        })->name('contacto');

        Route::post('/contacto', function () {
            // Procesar formulario de contacto
            return redirect()->route('contacto', ['locale' => app()->getLocale()])
                ->with('success', __('general.messages.success'));
        })->name('contacto.enviar');

        // Registro de fieles
        Route::get('/registro', function () {
            return view('pages.registro');
        })->name('registro');

        Route::post('/registro', function () {
            // Procesar registro de fiel
            return redirect()->route('registro', ['locale' => app()->getLocale()])
                ->with('success', __('general.messages.success'));
        })->name('registro.guardar');
    });
