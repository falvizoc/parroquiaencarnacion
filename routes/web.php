<?php

use App\Http\Controllers\VerificacionController;
use App\Models\Chapel;
use App\Models\Event;
use App\Models\MassSchedule;
use App\Models\News;
use App\Models\ParishGroup;
use App\Models\Priest;
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
            // Horarios de la parroquia principal agrupados por día
            $horariosPorDia = MassSchedule::activo()
                ->parroquiaPrincipal()
                ->ordenados()
                ->get()
                ->groupBy('dia_semana');

            return view('pages.inicio', compact('horariosPorDia'));
        })->name('inicio');

        // Horarios de misa
        Route::get('/horarios', function () {
            // Horarios de la parroquia principal
            $horariosParroquia = MassSchedule::activo()
                ->parroquiaPrincipal()
                ->ordenados()
                ->get()
                ->groupBy('dia_semana');

            // Capillas con sus horarios
            $capillas = Chapel::activo()
                ->ordenado()
                ->with(['massSchedules' => function ($query) {
                    $query->activo()->ordenados();
                }])
                ->get();

            return view('pages.horarios', compact('horariosParroquia', 'capillas'));
        })->name('horarios');

        // Noticias
        Route::get('/noticias', function () {
            $noticias = News::activo()->publicado()->reciente()->paginate(9);
            $noticiasDestacadas = News::activo()->publicado()->destacado()->reciente()->take(3)->get();
            return view('pages.noticias.index', compact('noticias', 'noticiasDestacadas'));
        })->name('noticias.index');

        Route::get('/noticias/{slug}', function (string $locale, string $slug) {
            $noticia = News::where('slug', $slug)->activo()->publicado()->firstOrFail();
            $otrasNoticias = News::activo()
                ->publicado()
                ->reciente()
                ->where('id', '!=', $noticia->id)
                ->take(3)
                ->get();
            return view('pages.noticias.detalle', compact('noticia', 'otrasNoticias'));
        })->name('noticias.detalle');

        // Eventos
        Route::get('/eventos', function () {
            $eventosProximos = Event::activo()->proximos()->take(12)->get();
            $eventosPasados = Event::activo()->pasados()->take(6)->get();
            return view('pages.eventos.index', compact('eventosProximos', 'eventosPasados'));
        })->name('eventos.index');

        Route::get('/eventos/{slug}', function (string $locale, string $slug) {
            $evento = Event::where('slug', $slug)->activo()->firstOrFail();
            $otrosEventos = Event::activo()
                ->proximos()
                ->where('id', '!=', $evento->id)
                ->take(3)
                ->get();
            return view('pages.eventos.detalle', compact('evento', 'otrosEventos'));
        })->name('eventos.detalle');

        // Grupos parroquiales
        Route::get('/grupos', function () {
            $grupos = ParishGroup::activo()->ordenado()->get();
            return view('pages.grupos.index', compact('grupos'));
        })->name('grupos.index');

        Route::get('/grupos/{slug}', function (string $locale, string $slug) {
            $grupo = ParishGroup::where('slug', $slug)->activo()->firstOrFail();
            $otrosGrupos = ParishGroup::activo()
                ->where('id', '!=', $grupo->id)
                ->ordenado()
                ->take(3)
                ->get();
            return view('pages.grupos.detalle', compact('grupo', 'otrosGrupos'));
        })->name('grupos.detalle');

        // Capillas
        Route::get('/capillas', function () {
            $capillas = Chapel::activo()->ordenado()->get();
            return view('pages.capillas.index', compact('capillas'));
        })->name('capillas.index');

        Route::get('/capillas/{slug}', function (string $locale, string $slug) {
            $capilla = Chapel::where('slug', $slug)->activo()->firstOrFail();
            $horarios = MassSchedule::where('chapel_id', $capilla->id)->activo()->ordenados()->get();
            $grupos = ParishGroup::where('chapel_id', $capilla->id)->activo()->ordenado()->get();
            $otrasCapillas = Chapel::activo()
                ->where('id', '!=', $capilla->id)
                ->ordenado()
                ->take(3)
                ->get();
            return view('pages.capillas.detalle', compact('capilla', 'horarios', 'grupos', 'otrasCapillas'));
        })->name('capillas.detalle');

        // Sacerdotes
        Route::get('/sacerdotes', function () {
            $parroco = Priest::activo()->parroco()->first();
            $vicarios = Priest::activo()->vicarios()->ordenado()->get();
            return view('pages.sacerdotes', compact('parroco', 'vicarios'));
        })->name('sacerdotes');

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
            // Procesar registro de fiel (ya no se usa, Livewire maneja esto)
            return redirect()->route('registro', ['locale' => app()->getLocale()])
                ->with('success', __('general.messages.success'));
        })->name('registro.guardar');

        // Verificación de email
        Route::get('/verificar/{id}/{token}', [VerificacionController::class, 'verificarEmail'])
            ->name('verificar.email');

        Route::post('/reenviar-verificacion', [VerificacionController::class, 'reenviarVerificacion'])
            ->name('reenviar.verificacion');
    });
