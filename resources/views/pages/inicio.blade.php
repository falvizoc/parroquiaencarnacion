@extends('layouts.app')

@section('title', __('general.site.name') . ' | ' . __('general.site.location'))
@section('description', __('general.seo.default_description'))

@section('content')
    {{-- Hero Section --}}
    <section class="relative bg-gradient-to-br from-primary-900 via-primary-800 to-primary-900 text-white overflow-hidden">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.4\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>

        <div class="container-main relative py-20 lg:py-32">
            <div class="max-w-3xl">
                <h1 class="font-serif text-4xl md:text-5xl lg:text-6xl font-bold mb-6 animate-fade-in">
                    {{ __('general.site.name') }}
                </h1>
                <p class="text-xl md:text-2xl text-white/90 mb-8 animate-fade-in">
                    {{ __('general.site.tagline') }}
                </p>
                <div class="flex flex-wrap gap-4 animate-fade-in">
                    <a href="{{ route('horarios', ['locale' => app()->getLocale()]) }}" class="btn-primary bg-white text-primary-700 hover:bg-gray-100">
                        {{ __('general.nav.schedules') }}
                    </a>
                    <a href="{{ route('contacto', ['locale' => app()->getLocale()]) }}" class="btn-secondary border-white text-white hover:bg-white/10">
                        {{ __('general.nav.contact') }}
                    </a>
                </div>
            </div>
        </div>

        {{-- Wave Divider --}}
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto">
                <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="#f9fafb"/>
            </svg>
        </div>
    </section>

    {{-- Horarios Destacados --}}
    <section class="py-16 lg:py-24 bg-gray-50">
        <div class="container-main">
            <div class="text-center mb-12">
                <h2 class="font-serif text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    {{ __('general.nav.schedules') }}
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Te invitamos a participar en nuestras celebraciones eucarísticas.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                {{-- Domingo --}}
                <div class="card p-6 text-center hover:shadow-md transition-shadow">
                    <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-lg text-gray-900 mb-2">{{ __('general.days.sunday') }}</h3>
                    <p class="text-gray-600 text-sm">
                        @if(isset($horariosPorDia[0]) && $horariosPorDia[0]->count() > 0)
                            {{ $horariosPorDia[0]->pluck('hora')->map(fn($h) => $h->format('H:i'))->implode(', ') }}
                        @else
                            Consultar horarios
                        @endif
                    </p>
                </div>

                {{-- Entre Semana --}}
                <div class="card p-6 text-center hover:shadow-md transition-shadow">
                    <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-lg text-gray-900 mb-2">Lunes a Viernes</h3>
                    <p class="text-gray-600 text-sm">
                        @php
                            // Obtener horarios únicos de lunes (día 1) como referencia
                            $horariosEntreSemana = isset($horariosPorDia[1])
                                ? $horariosPorDia[1]->pluck('hora')->map(fn($h) => $h->format('H:i'))->unique()->implode(', ')
                                : 'Consultar horarios';
                        @endphp
                        {{ $horariosEntreSemana }}
                    </p>
                </div>

                {{-- Sábado --}}
                <div class="card p-6 text-center hover:shadow-md transition-shadow">
                    <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-lg text-gray-900 mb-2">{{ __('general.days.saturday') }}</h3>
                    <p class="text-gray-600 text-sm">
                        @if(isset($horariosPorDia[6]) && $horariosPorDia[6]->count() > 0)
                            {{ $horariosPorDia[6]->pluck('hora')->map(fn($h) => $h->format('H:i'))->implode(', ') }}
                        @else
                            Consultar horarios
                        @endif
                    </p>
                </div>
            </div>

            <div class="text-center mt-8">
                <a href="{{ route('horarios', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-700 font-medium">
                    {{ __('general.actions.view_all') }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    {{-- Próximos Eventos --}}
    <section class="py-16 lg:py-24">
        <div class="container-main">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-12">
                <div>
                    <h2 class="font-serif text-3xl lg:text-4xl font-bold text-gray-900 mb-2">
                        Próximos Eventos
                    </h2>
                    <p class="text-gray-600">
                        Actividades y celebraciones de nuestra comunidad parroquial.
                    </p>
                </div>
                <a href="{{ route('eventos.index', ['locale' => app()->getLocale()]) }}" class="btn-secondary">
                    {{ __('general.actions.view_all') }}
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {{-- Evento Placeholder 1 --}}
                <article class="card group">
                    <div class="aspect-video bg-gradient-to-br from-primary-100 to-primary-200 relative overflow-hidden">
                        <div class="absolute top-4 left-4 bg-white rounded-lg px-3 py-2 shadow-sm">
                            <div class="text-xs text-gray-500 uppercase">Ene</div>
                            <div class="text-xl font-bold text-primary-600">15</div>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="font-semibold text-lg text-gray-900 mb-2 group-hover:text-primary-600 transition-colors">
                            Retiro de Adviento
                        </h3>
                        <p class="text-gray-600 text-sm mb-4">
                            Jornada de reflexión y oración para preparar nuestros corazones.
                        </p>
                        <div class="flex items-center gap-4 text-sm text-gray-500">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                9:00 AM
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                                Salón Parroquial
                            </span>
                        </div>
                    </div>
                </article>

                {{-- Evento Placeholder 2 --}}
                <article class="card group">
                    <div class="aspect-video bg-gradient-to-br from-gold-100 to-gold-200 relative overflow-hidden">
                        <div class="absolute top-4 left-4 bg-white rounded-lg px-3 py-2 shadow-sm">
                            <div class="text-xs text-gray-500 uppercase">Ene</div>
                            <div class="text-xl font-bold text-primary-600">20</div>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="font-semibold text-lg text-gray-900 mb-2 group-hover:text-primary-600 transition-colors">
                            Misa de Sanación
                        </h3>
                        <p class="text-gray-600 text-sm mb-4">
                            Celebración especial con imposición de manos y oración por los enfermos.
                        </p>
                        <div class="flex items-center gap-4 text-sm text-gray-500">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                7:00 PM
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                                Templo Principal
                            </span>
                        </div>
                    </div>
                </article>

                {{-- Evento Placeholder 3 --}}
                <article class="card group">
                    <div class="aspect-video bg-gradient-to-br from-primary-200 to-primary-300 relative overflow-hidden">
                        <div class="absolute top-4 left-4 bg-white rounded-lg px-3 py-2 shadow-sm">
                            <div class="text-xs text-gray-500 uppercase">Ene</div>
                            <div class="text-xl font-bold text-primary-600">25</div>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="font-semibold text-lg text-gray-900 mb-2 group-hover:text-primary-600 transition-colors">
                            Taller para Catequistas
                        </h3>
                        <p class="text-gray-600 text-sm mb-4">
                            Formación continua para todos los catequistas de la parroquia.
                        </p>
                        <div class="flex items-center gap-4 text-sm text-gray-500">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                10:00 AM
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                                Aula 3
                            </span>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>

    {{-- Adoración Perpetua CTA --}}
    <section class="py-16 lg:py-24 bg-gradient-to-br from-gold-50 to-gold-100">
        <div class="container-main">
            <div class="max-w-4xl mx-auto text-center">
                <div class="w-20 h-20 bg-gold-200 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-gold-700" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                </div>
                <h2 class="font-serif text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    Capilla de Adoración Perpetua
                </h2>
                <p class="text-gray-600 text-lg mb-8 max-w-2xl mx-auto">
                    Nuestra capilla está abierta las 24 horas del día, los 7 días de la semana.
                    Te invitamos a pasar un momento en presencia del Santísimo Sacramento.
                </p>
                <a href="{{ route('adoracion', ['locale' => app()->getLocale()]) }}" class="btn-primary">
                    Conoce más sobre la Adoración
                </a>
            </div>
        </div>
    </section>

    {{-- Zona de Criptas --}}
    @if($criptasInfo)
    <section class="py-16 lg:py-24 bg-gray-100">
        <div class="container-main">
            {{-- Banner de Campaña (si hay vigente) --}}
            @if($criptasCampana)
            <div class="mb-12 rounded-xl overflow-hidden shadow-lg"
                 style="background-color: {{ $criptasCampana->color_fondo }}">
                @if($criptasCampana->imagen_banner)
                    <div class="relative">
                        <img src="{{ Storage::url($criptasCampana->imagen_banner) }}"
                             alt="{{ $criptasCampana->titulo }}"
                             class="w-full h-48 md:h-64 object-cover">
                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                            <div class="text-center text-white p-6">
                                <h3 class="font-serif text-2xl md:text-3xl font-bold mb-2">{{ $criptasCampana->titulo }}</h3>
                                <p class="text-white/90 max-w-2xl">{{ $criptasCampana->descripcion }}</p>
                                @if($criptasCampana->texto_boton && $criptasCampana->url_boton)
                                    <a href="{{ $criptasCampana->url_boton }}" class="inline-block mt-4 bg-white text-gray-900 font-semibold py-2 px-6 rounded-lg hover:bg-gray-100 transition-colors">
                                        {{ $criptasCampana->texto_boton }}
                                    </a>
                                @endif
                                @if($criptasCampana->dias_restantes > 0)
                                    <p class="text-sm text-white/80 mt-3">{{ $criptasCampana->dias_restantes }} días restantes</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <div class="p-8 md:p-12 text-center text-white">
                        <h3 class="font-serif text-2xl md:text-3xl font-bold mb-2">{{ $criptasCampana->titulo }}</h3>
                        <p class="text-white/90 max-w-2xl mx-auto">{{ $criptasCampana->descripcion }}</p>
                        @if($criptasCampana->texto_boton && $criptasCampana->url_boton)
                            <a href="{{ $criptasCampana->url_boton }}" class="inline-block mt-4 bg-white text-gray-900 font-semibold py-2 px-6 rounded-lg hover:bg-gray-100 transition-colors">
                                {{ $criptasCampana->texto_boton }}
                            </a>
                        @endif
                        @if($criptasCampana->dias_restantes > 0)
                            <p class="text-sm text-white/80 mt-3">{{ $criptasCampana->dias_restantes }} días restantes</p>
                        @endif
                    </div>
                @endif
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                {{-- Imagen --}}
                <div class="order-2 lg:order-1">
                    @if($criptasInfo->imagen)
                        <img src="{{ Storage::url($criptasInfo->imagen) }}"
                             alt="{{ $criptasInfo->titulo }}"
                             class="rounded-xl shadow-lg w-full">
                    @else
                        <div class="bg-gradient-to-br from-gray-200 to-gray-300 rounded-xl aspect-video flex items-center justify-center">
                            <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                    @endif
                </div>

                {{-- Contenido --}}
                <div class="order-1 lg:order-2">
                    <h2 class="font-serif text-3xl lg:text-4xl font-bold text-gray-900 mb-2">
                        {{ $criptasInfo->titulo }}
                    </h2>
                    @if($criptasInfo->subtitulo)
                        <p class="text-lg text-primary-600 font-medium mb-4">{{ $criptasInfo->subtitulo }}</p>
                    @endif
                    <p class="text-gray-600 mb-6">
                        {{ $criptasInfo->descripcion_corta ?? Str::limit(strip_tags($criptasInfo->descripcion), 200) }}
                    </p>

                    {{-- Información de contacto --}}
                    <div class="space-y-3 mb-6">
                        @if($criptasInfo->telefono_contacto)
                        <div class="flex items-center gap-3 text-gray-600">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span>{{ $criptasInfo->telefono_contacto }}</span>
                        </div>
                        @endif
                        @if($criptasInfo->horario_atencion)
                        <div class="flex items-center gap-3 text-gray-600">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ $criptasInfo->horario_atencion }}</span>
                        </div>
                        @endif
                    </div>

                    <a href="{{ route('contacto', ['locale' => app()->getLocale()]) }}" class="btn-primary">
                        Solicitar información
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- Grupos Parroquiales --}}
    <section class="py-16 lg:py-24">
        <div class="container-main">
            <div class="text-center mb-12">
                <h2 class="font-serif text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    {{ __('general.nav.groups') }}
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Únete a una de nuestras comunidades y crece en tu fe junto a otros hermanos.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach(['Coro', 'Catequesis', 'Jóvenes', 'Matrimonios', 'Legión de María', 'Ministros'] as $grupo)
                <a href="{{ route('grupos.index', ['locale' => app()->getLocale()]) }}" class="card p-6 text-center hover:shadow-md hover:border-primary-200 transition-all group">
                    <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:bg-primary-200 transition-colors">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-medium text-gray-900 text-sm">{{ $grupo }}</h3>
                </a>
                @endforeach
            </div>

            <div class="text-center mt-8">
                <a href="{{ route('grupos.index', ['locale' => app()->getLocale()]) }}" class="btn-secondary">
                    Ver todos los grupos
                </a>
            </div>
        </div>
    </section>

    {{-- CTA Registro --}}
    <section class="py-16 lg:py-24 bg-primary-900 text-white">
        <div class="container-main text-center">
            <h2 class="font-serif text-3xl lg:text-4xl font-bold mb-4">
                ¿Eres nuevo en nuestra parroquia?
            </h2>
            <p class="text-white/80 text-lg mb-8 max-w-2xl mx-auto">
                Regístrate como fiel de nuestra comunidad y mantente informado sobre nuestras actividades,
                eventos especiales y comunicaciones importantes.
            </p>
            <a href="{{ route('registro', ['locale' => app()->getLocale()]) }}" class="btn-primary bg-white text-primary-700 hover:bg-gray-100">
                {{ __('general.nav.register') }}
            </a>
        </div>
    </section>
@endsection
