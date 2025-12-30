@extends('layouts.app')

@section('title', __('general.nav.events') . ' | ' . __('general.site.short_name'))
@section('description', 'Calendario de eventos y actividades de la Parroquia Nuestra Señora de la Encarnación en Tampico.')

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
                        <span class="text-white">{{ __('general.nav.events') }}</span>
                    </li>
                </ol>
            </nav>
            <h1 class="font-serif text-4xl lg:text-5xl font-bold">{{ __('general.nav.events') }}</h1>
            <p class="mt-4 text-white/80 text-lg max-w-2xl">
                Calendario de actividades y celebraciones de nuestra comunidad parroquial.
            </p>
        </div>
    </section>

    {{-- Próximos Eventos --}}
    <section class="py-16 lg:py-24">
        <div class="container-main">
            <h2 class="font-serif text-2xl lg:text-3xl font-bold text-gray-900 mb-8">
                Próximos Eventos
            </h2>

            @if($eventosProximos->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($eventosProximos as $evento)
                        <article class="card group hover:shadow-xl transition-all duration-300 overflow-hidden">
                            {{-- Imagen --}}
                            <div class="aspect-video bg-gray-100 relative overflow-hidden">
                                @if($evento->imagen)
                                    <img src="{{ $evento->imagen_url }}"
                                         alt="{{ $evento->titulo }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary-100 to-primary-200">
                                        <svg class="w-16 h-16 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif

                                {{-- Fecha badge --}}
                                <div class="absolute top-4 left-4 bg-white rounded-lg shadow-lg p-2 text-center min-w-[60px]">
                                    <div class="text-2xl font-bold text-primary-600">{{ $evento->fecha_inicio->format('d') }}</div>
                                    <div class="text-xs uppercase text-gray-500">{{ $evento->fecha_inicio->translatedFormat('M') }}</div>
                                </div>

                                {{-- Categoría badge --}}
                                <div class="absolute top-4 right-4">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full
                                        @switch($evento->categoria)
                                            @case('liturgico') bg-primary-100 text-primary-700 @break
                                            @case('social') bg-green-100 text-green-700 @break
                                            @case('formacion') bg-yellow-100 text-yellow-700 @break
                                            @case('comunitario') bg-blue-100 text-blue-700 @break
                                            @default bg-gray-100 text-gray-700
                                        @endswitch
                                    ">
                                        {{ $evento->nombre_categoria }}
                                    </span>
                                </div>
                            </div>

                            {{-- Contenido --}}
                            <div class="p-6">
                                <h3 class="font-serif text-xl font-bold text-gray-900 mb-2 group-hover:text-primary-600 transition-colors">
                                    <a href="{{ route('eventos.detalle', ['locale' => app()->getLocale(), 'slug' => $evento->slug]) }}">
                                        {{ $evento->titulo }}
                                    </a>
                                </h3>

                                @if($evento->descripcion_corta)
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                        {{ $evento->descripcion_corta }}
                                    </p>
                                @endif

                                <div class="space-y-2 text-sm text-gray-500">
                                    {{-- Horario --}}
                                    @if($evento->horario_formateado)
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span>{{ $evento->horario_formateado }}</span>
                                        </div>
                                    @endif

                                    {{-- Lugar --}}
                                    @if($evento->lugar)
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            <span>{{ $evento->lugar }}</span>
                                        </div>
                                    @endif
                                </div>

                                <a href="{{ route('eventos.detalle', ['locale' => app()->getLocale(), 'slug' => $evento->slug]) }}"
                                   class="inline-flex items-center gap-1 text-primary-600 hover:text-primary-700 font-medium text-sm mt-4">
                                    Ver detalles
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-gray-50 rounded-xl">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-gray-500">No hay eventos próximos programados.</p>
                    <p class="text-gray-400 text-sm mt-2">Vuelve pronto para conocer nuestras actividades.</p>
                </div>
            @endif
        </div>
    </section>

    {{-- Eventos Pasados --}}
    @if($eventosPasados->count() > 0)
        <section class="py-16 bg-gray-50">
            <div class="container-main">
                <h2 class="font-serif text-2xl lg:text-3xl font-bold text-gray-900 mb-8">
                    Eventos Anteriores
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($eventosPasados as $evento)
                        <article class="card p-4 opacity-75 hover:opacity-100 transition-opacity">
                            <div class="flex gap-4">
                                <div class="flex-shrink-0 w-16 h-16 bg-gray-200 rounded-lg flex flex-col items-center justify-center">
                                    <div class="text-lg font-bold text-gray-600">{{ $evento->fecha_inicio->format('d') }}</div>
                                    <div class="text-xs uppercase text-gray-500">{{ $evento->fecha_inicio->translatedFormat('M') }}</div>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-700">
                                        <a href="{{ route('eventos.detalle', ['locale' => app()->getLocale(), 'slug' => $evento->slug]) }}"
                                           class="hover:text-primary-600">
                                            {{ $evento->titulo }}
                                        </a>
                                    </h3>
                                    <p class="text-sm text-gray-500">{{ $evento->nombre_categoria }}</p>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- CTA --}}
    <section class="py-12 bg-primary-900 text-white">
        <div class="container-main text-center">
            <h2 class="text-2xl font-bold mb-4">¿Tienes alguna pregunta sobre nuestros eventos?</h2>
            <p class="text-white/80 mb-6">Contáctanos para más información.</p>
            <a href="{{ route('contacto', ['locale' => app()->getLocale()]) }}" class="btn-primary bg-white text-primary-700 hover:bg-gray-100">
                {{ __('general.nav.contact') }}
            </a>
        </div>
    </section>
@endsection
