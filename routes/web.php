<?php

use App\Http\Controllers\SitemapController;
use App\Http\Controllers\VerificacionController;
use App\Models\Chapel;
use App\Models\CryptCampaign;
use App\Models\CryptInfo;
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

// SEO Routes
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', function () {
    return response(view('seo.robots')->render(), 200)
        ->header('Content-Type', 'text/plain');
})->name('robots');
Route::get('/llms.txt', function () {
    return response(view('seo.llms')->render(), 200)
        ->header('Content-Type', 'text/plain; charset=utf-8');
})->name('llms');

// Ruta raíz - redirige al idioma predeterminado
Route::get('/', function () {
    return redirect('/es');
});

// Cambio de idioma
Route::get('/idioma/{locale}', function (string $locale) {
    if (!in_array($locale, ['es', 'en'])) {
        return redirect()->back();
    }

    session()->put('locale', $locale);

    // Obtener la URL anterior y reemplazar el prefijo de idioma
    $urlAnterior = url()->previous();
    $urlActual = url('/');

    // Extraer el path relativo de la URL anterior
    $pathAnterior = str_replace($urlActual, '', $urlAnterior);

    // Reemplazar el prefijo de idioma en el path
    $idiomaAnterior = app()->getLocale();
    if (str_starts_with($pathAnterior, '/' . $idiomaAnterior)) {
        $pathNuevo = '/' . $locale . substr($pathAnterior, 3);
    } elseif (str_starts_with($pathAnterior, '/es') || str_starts_with($pathAnterior, '/en')) {
        // Si el path empieza con /es o /en, reemplazar
        $pathNuevo = '/' . $locale . substr($pathAnterior, 3);
    } else {
        // Si no hay prefijo de idioma, agregarlo
        $pathNuevo = '/' . $locale . $pathAnterior;
    }

    return redirect($pathNuevo);
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

            // Información de criptas para mostrar en inicio
            $criptasInfo = CryptInfo::paraInicio();
            $criptasCampana = CryptCampaign::obtenerVigente();

            // Próximos eventos (con traducción si está en inglés)
            $eventosProximos = Event::activo()
                ->conTraduccion()
                ->proximos()
                ->take(3)
                ->get();

            // Grupos parroquiales destacados (con traducción)
            $gruposDestacados = ParishGroup::activo()
                ->conTraduccion()
                ->ordenado()
                ->take(6)
                ->get();

            return view('pages.inicio', compact(
                'horariosPorDia',
                'criptasInfo',
                'criptasCampana',
                'eventosProximos',
                'gruposDestacados'
            ));
        })->name('inicio');

        // Horarios de misa
        Route::get('/horarios', function () {
            // Horarios de la parroquia principal
            $horariosParroquia = MassSchedule::activo()
                ->parroquiaPrincipal()
                ->ordenados()
                ->get()
                ->groupBy('dia_semana');

            // Capillas con sus horarios (solo las traducidas)
            $capillas = Chapel::activo()
                ->conTraduccion()
                ->ordenado()
                ->with(['massSchedules' => function ($query) {
                    $query->activo()->ordenados();
                }])
                ->get();

            return view('pages.horarios', compact('horariosParroquia', 'capillas'));
        })->name('horarios');

        // Noticias
        Route::get('/noticias', function () {
            $noticias = News::activo()->publicado()->conTraduccion()->reciente()->paginate(9);
            $noticiasDestacadas = News::activo()->publicado()->conTraduccion()->destacado()->reciente()->take(3)->get();
            return view('pages.noticias.index', compact('noticias', 'noticiasDestacadas'));
        })->name('noticias.index');

        Route::get('/noticias/{slug}', function (string $locale, string $slug) {
            $noticia = News::where('slug', $slug)->activo()->publicado()->firstOrFail();
            $otrasNoticias = News::activo()
                ->publicado()
                ->conTraduccion()
                ->reciente()
                ->where('id', '!=', $noticia->id)
                ->take(3)
                ->get();
            return view('pages.noticias.detalle', compact('noticia', 'otrasNoticias'));
        })->name('noticias.detalle');

        // Eventos
        Route::get('/eventos', function () {
            $eventosProximos = Event::activo()->conTraduccion()->proximos()->take(12)->get();
            $eventosPasados = Event::activo()->conTraduccion()->pasados()->take(6)->get();
            return view('pages.eventos.index', compact('eventosProximos', 'eventosPasados'));
        })->name('eventos.index');

        Route::get('/eventos/{slug}', function (string $locale, string $slug) {
            $evento = Event::where('slug', $slug)->activo()->firstOrFail();
            $otrosEventos = Event::activo()
                ->conTraduccion()
                ->proximos()
                ->where('id', '!=', $evento->id)
                ->take(3)
                ->get();
            return view('pages.eventos.detalle', compact('evento', 'otrosEventos'));
        })->name('eventos.detalle');

        // Grupos parroquiales
        Route::get('/grupos', function () {
            $grupos = ParishGroup::activo()->conTraduccion()->ordenado()->get();
            return view('pages.grupos.index', compact('grupos'));
        })->name('grupos.index');

        Route::get('/grupos/{slug}', function (string $locale, string $slug) {
            $grupo = ParishGroup::where('slug', $slug)->activo()->firstOrFail();
            $otrosGrupos = ParishGroup::activo()
                ->conTraduccion()
                ->where('id', '!=', $grupo->id)
                ->ordenado()
                ->take(3)
                ->get();
            return view('pages.grupos.detalle', compact('grupo', 'otrosGrupos'));
        })->name('grupos.detalle');

        // Capillas
        Route::get('/capillas', function () {
            $capillas = Chapel::activo()->conTraduccion()->ordenado()->get();
            return view('pages.capillas.index', compact('capillas'));
        })->name('capillas.index');

        Route::get('/capillas/{slug}', function (string $locale, string $slug) {
            $capilla = Chapel::where('slug', $slug)->activo()->firstOrFail();
            $horarios = MassSchedule::where('chapel_id', $capilla->id)->activo()->ordenados()->get();
            $grupos = ParishGroup::where('chapel_id', $capilla->id)->activo()->conTraduccion()->ordenado()->get();
            $otrasCapillas = Chapel::activo()
                ->conTraduccion()
                ->where('id', '!=', $capilla->id)
                ->ordenado()
                ->take(3)
                ->get();
            return view('pages.capillas.detalle', compact('capilla', 'horarios', 'grupos', 'otrasCapillas'));
        })->name('capillas.detalle');

        // Sacerdotes
        Route::get('/sacerdotes', function () {
            $parroco = Priest::activo()->conTraduccion()->parroco()->first();
            $vicarios = Priest::activo()->conTraduccion()->vicarios()->ordenado()->get();
            return view('pages.sacerdotes', compact('parroco', 'vicarios'));
        })->name('sacerdotes');

        // Adoración perpetua
        Route::get('/adoracion', function () {
            return view('pages.adoracion');
        })->name('adoracion');

        // Nuestra Parroquia (About)
        Route::get('/nosotros', function () {
            return view('pages.nosotros');
        })->name('nosotros');

        // Contacto
        Route::get('/contacto', function () {
            return view('pages.contacto');
        })->name('contacto');

        Route::post('/contacto', function () {
            // Procesar formulario de contacto
            return redirect()->route('contacto', ['locale' => app()->getLocale()])
                ->with('success', __('general.messages.success'));
        })->name('contacto.enviar')->middleware('throttle:formularios');

        // Registro de fieles
        Route::get('/registro', function () {
            return view('pages.registro');
        })->name('registro');

        Route::post('/registro', function () {
            // Procesar registro de fiel (ya no se usa, Livewire maneja esto)
            return redirect()->route('registro', ['locale' => app()->getLocale()])
                ->with('success', __('general.messages.success'));
        })->name('registro.guardar')->middleware('throttle:formularios');

        // Verificación de email
        Route::get('/verificar/{id}/{token}', [VerificacionController::class, 'verificarEmail'])
            ->name('verificar.email');

        Route::post('/reenviar-verificacion', [VerificacionController::class, 'reenviarVerificacion'])
            ->name('reenviar.verificacion')
            ->middleware('throttle:verificacion');

        // Newsletter y preferencias
        Route::get('/newsletter', function () {
            return view('pages.newsletter');
        })->name('newsletter');

        Route::get('/preferencias/{token}', function (string $locale, string $token) {
            return view('pages.preferencias', compact('token'));
        })->name('preferencias');

        Route::get('/cancelar-suscripcion/{token}', function (string $locale, string $token) {
            $fiel = \App\Models\FaithfulMember::where('token_preferencias', $token)->first();

            if ($fiel) {
                $fiel->update([
                    'recibir_newsletter' => false,
                    'recibir_eventos' => false,
                    'recibir_avisos' => false,
                ]);
            }

            return view('pages.cancelar-suscripcion', ['exito' => $fiel !== null]);
        })->name('cancelar-suscripcion');
    });
