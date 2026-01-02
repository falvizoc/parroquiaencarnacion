@extends('layouts.app')

@section('title', __('general.nav.adoration') . ' | ' . __('general.site.short_name'))
@section('description', 'Capilla de Adoración Perpetua de la Parroquia Nuestra Señora de la Encarnación. Abierta las 24 horas, los 7 días de la semana.')

@php
    use App\Models\Setting;
    use Illuminate\Support\Facades\Storage;

    $imagen_adoracion = Setting::obtener('adoracion_imagen');
    $posicion_adoracion = Setting::obtener('adoracion_posicion', 'center');
    $efectos_activos = Setting::obtener('adoracion_efectos_activos', true);
    $tiene_imagen = !empty($imagen_adoracion);

    $bg_position = match($posicion_adoracion) {
        'top' => 'top',
        'bottom' => 'bottom',
        default => 'center',
    };
@endphp

@section('content')
    {{-- Hero --}}
    <section class="relative text-white py-16 lg:py-24 overflow-hidden
                   {{ !$tiene_imagen ? 'bg-gradient-to-br from-gold-600 to-gold-800' : '' }}">

        @if($tiene_imagen)
            {{-- Imagen de fondo --}}
            <div class="absolute inset-0 parallax-container">
                <div class="parallax-bg"
                     @if($efectos_activos) data-parallax="adoracion" @endif
                     style="background-image: url('{{ Storage::url($imagen_adoracion) }}'); background-position: center {{ $bg_position }};">
                </div>
            </div>

            {{-- Overlay dorado --}}
            <div class="adoracion-overlay"></div>

            {{-- Shimmer dorado --}}
            @if($efectos_activos)
                <div class="gold-shimmer"></div>
            @endif
        @endif

        <div class="container-main relative z-10">
            <nav class="text-sm mb-4" aria-label="Breadcrumb">
                <ol class="flex items-center gap-2 text-white/70">
                    <li>
                        <a href="{{ route('inicio', ['locale' => app()->getLocale()]) }}" class="hover:text-white">
                            {{ __('general.nav.home') }}
                        </a>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        <span class="text-white">{{ __('general.nav.adoration') }}</span>
                    </li>
                </ol>
            </nav>

            <div class="max-w-3xl">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                </div>
                <h1 class="font-serif text-4xl lg:text-5xl font-bold mb-4">
                    Capilla de Adoración Perpetua
                </h1>
                <p class="text-xl text-white/90">
                    Un espacio de encuentro con Jesús Sacramentado, disponible las 24 horas del día, los 7 días de la semana.
                </p>
            </div>
        </div>
    </section>

    {{-- Contenido Principal --}}
    <section class="py-16 lg:py-24">
        <div class="container-main">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                {{-- Columna Principal --}}
                <div class="lg:col-span-2 space-y-12">
                    {{-- ¿Qué es la Adoración? --}}
                    <div>
                        <h2 class="font-serif text-3xl font-bold text-gray-900 mb-6">
                            ¿Qué es la Adoración Perpetua?
                        </h2>
                        <div class="prose prose-lg max-w-none text-gray-600">
                            <p>
                                La Adoración Perpetua es la práctica devocional de adorar a Jesús presente en la Eucaristía
                                de manera continua, las 24 horas del día. En nuestra capilla, el Santísimo Sacramento está
                                expuesto permanentemente para que los fieles puedan venir a orar y meditar en cualquier momento.
                            </p>
                            <p>
                                Esta devoción tiene profundas raíces en la tradición católica y nos permite experimentar
                                un encuentro íntimo con Cristo, fortaleciendo nuestra fe y nuestra relación con Dios.
                            </p>
                        </div>
                    </div>

                    {{-- Beneficios --}}
                    <div>
                        <h2 class="font-serif text-2xl font-bold text-gray-900 mb-6">
                            Frutos de la Adoración
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex gap-4">
                                <div class="w-12 h-12 bg-gold-100 rounded-lg flex items-center justify-center shrink-0">
                                    <svg class="w-6 h-6 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Paz interior</h3>
                                    <p class="text-gray-600 text-sm mt-1">Encuentra tranquilidad en la presencia de Cristo.</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="w-12 h-12 bg-gold-100 rounded-lg flex items-center justify-center shrink-0">
                                    <svg class="w-6 h-6 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Fortaleza espiritual</h3>
                                    <p class="text-gray-600 text-sm mt-1">Renueva tu fe y encuentra fuerzas para los desafíos.</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="w-12 h-12 bg-gold-100 rounded-lg flex items-center justify-center shrink-0">
                                    <svg class="w-6 h-6 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Comunidad de fe</h3>
                                    <p class="text-gray-600 text-sm mt-1">Únete a otros fieles en oración continua.</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="w-12 h-12 bg-gold-100 rounded-lg flex items-center justify-center shrink-0">
                                    <svg class="w-6 h-6 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Tiempo con Dios</h3>
                                    <p class="text-gray-600 text-sm mt-1">Dedica momentos exclusivos a tu relación con el Señor.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Cómo participar --}}
                    <div class="bg-gray-50 rounded-xl p-8">
                        <h2 class="font-serif text-2xl font-bold text-gray-900 mb-6">
                            ¿Cómo participar?
                        </h2>
                        <ol class="space-y-4">
                            <li class="flex gap-4">
                                <span class="w-8 h-8 bg-primary-600 text-white rounded-full flex items-center justify-center font-bold shrink-0">1</span>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Visita la capilla</h3>
                                    <p class="text-gray-600 text-sm mt-1">Puedes venir en cualquier momento, de día o de noche.</p>
                                </div>
                            </li>
                            <li class="flex gap-4">
                                <span class="w-8 h-8 bg-primary-600 text-white rounded-full flex items-center justify-center font-bold shrink-0">2</span>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Comprométete a una hora</h3>
                                    <p class="text-gray-600 text-sm mt-1">Si deseas, puedes adoptar una hora semanal fija para asegurar que siempre haya adoradores.</p>
                                </div>
                            </li>
                            <li class="flex gap-4">
                                <span class="w-8 h-8 bg-primary-600 text-white rounded-full flex items-center justify-center font-bold shrink-0">3</span>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Regístrate como adorador</h3>
                                    <p class="text-gray-600 text-sm mt-1">Contáctanos para formar parte del grupo de adoradores comprometidos.</p>
                                </div>
                            </li>
                        </ol>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="lg:col-span-1 space-y-6">
                    {{-- Horario --}}
                    <div class="card p-6 border-2 border-gold-200 bg-gold-50">
                        <h3 class="font-semibold text-lg text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Horario
                        </h3>
                        <p class="text-gray-600">
                            <strong class="text-gray-900">Abierto 24/7</strong><br>
                            Las 24 horas del día, los 7 días de la semana.
                        </p>
                    </div>

                    {{-- Ubicación --}}
                    <div class="card p-6">
                        <h3 class="font-semibold text-lg text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                            Ubicación
                        </h3>
                        <p class="text-gray-600">
                            Capilla anexa al templo principal.<br>
                            Entrada por la puerta lateral.
                        </p>
                    </div>

                    {{-- Contacto --}}
                    <div class="card p-6">
                        <h3 class="font-semibold text-lg text-gray-900 mb-4">¿Quieres ser adorador?</h3>
                        <p class="text-gray-600 text-sm mb-4">
                            Contáctanos para unirte al grupo de adoradores y adoptar una hora semanal.
                        </p>
                        <a href="{{ route('contacto', ['locale' => app()->getLocale()]) }}" class="btn-primary w-full text-center">
                            Contactar
                        </a>
                    </div>

                    {{-- Cita --}}
                    <div class="bg-primary-50 rounded-xl p-6">
                        <blockquote class="text-gray-700 italic">
                            "Vengan a mí todos los que están cansados y agobiados, y yo les daré descanso."
                        </blockquote>
                        <p class="text-primary-600 font-medium mt-3 text-sm">— Mateo 11:28</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
