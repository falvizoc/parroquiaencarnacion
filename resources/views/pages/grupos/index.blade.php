@extends('layouts.app')

@section('title', __('general.nav.groups') . ' | ' . __('general.site.short_name'))
@section('description', 'Grupos y comunidades parroquiales de la Parroquia Nuestra Señora de la Encarnación en Tampico. Únete a nuestra comunidad de fe.')

@section('content')
    {{-- Hero --}}
    <section class="bg-gradient-to-br from-primary-800 to-primary-900 text-white py-16">
        <div class="container-main">
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
                        <span class="text-white">{{ __('general.nav.groups') }}</span>
                    </li>
                </ol>
            </nav>
            <h1 class="font-serif text-4xl lg:text-5xl font-bold">{{ __('general.nav.groups') }}</h1>
            <p class="mt-4 text-white/80 text-lg max-w-2xl">
                Comunidades de fe donde puedes crecer espiritualmente junto a otros hermanos.
                Encuentra tu lugar en nuestra parroquia.
            </p>
        </div>
    </section>

    {{-- Listado de Grupos --}}
    <section class="py-16 lg:py-24">
        <div class="container-main">
            @if($grupos->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($grupos as $grupo)
                    <article class="card group hover:shadow-xl transition-all duration-300">
                        {{-- Imagen --}}
                        <div class="aspect-video bg-gray-100 overflow-hidden">
                            @if($grupo->imagen)
                                <img src="{{ $grupo->imagen_url }}"
                                     alt="{{ $grupo->nombre }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary-100 to-primary-200">
                                    <svg class="w-16 h-16 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        {{-- Contenido --}}
                        <div class="p-6">
                            <h2 class="font-serif text-xl font-bold text-gray-900 mb-2 group-hover:text-primary-600 transition-colors">
                                <a href="{{ route('grupos.detalle', ['locale' => app()->getLocale(), 'slug' => $grupo->slug]) }}">
                                    {{ $grupo->nombre }}
                                </a>
                            </h2>

                            @if($grupo->descripcion_corta)
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                    {{ $grupo->descripcion_corta }}
                                </p>
                            @endif

                            {{-- Horario --}}
                            @if($grupo->horario_formateado)
                                <div class="flex items-center gap-2 text-sm text-primary-600 mb-4">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>{{ $grupo->horario_formateado }}</span>
                                </div>
                            @endif

                            {{-- Lugar --}}
                            @if($grupo->lugar_reunion)
                                <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span>{{ $grupo->lugar_reunion }}</span>
                                </div>
                            @endif

                            <a href="{{ route('grupos.detalle', ['locale' => app()->getLocale(), 'slug' => $grupo->slug]) }}"
                               class="inline-flex items-center gap-1 text-primary-600 hover:text-primary-700 font-medium text-sm">
                                Conocer más
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </article>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <p class="text-gray-500">No hay grupos disponibles en este momento.</p>
                </div>
            @endif

            {{-- CTA --}}
            <div class="mt-16 bg-primary-50 rounded-2xl p-8 lg:p-12 text-center">
                <h2 class="font-serif text-2xl lg:text-3xl font-bold text-primary-900 mb-4">
                    ¿Interesado en unirte a algún grupo?
                </h2>
                <p class="text-gray-600 mb-6 max-w-xl mx-auto">
                    Contáctanos para más información sobre cómo participar en nuestras comunidades de fe.
                </p>
                <a href="{{ route('contacto', ['locale' => app()->getLocale()]) }}" class="btn-primary">
                    Contáctanos
                </a>
            </div>
        </div>
    </section>
@endsection
