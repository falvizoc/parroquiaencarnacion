@extends('layouts.app')

@section('title', __('general.nav.news') . ' | ' . __('general.site.short_name'))
@section('description', __('general.events.calendar_description'))

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
                        <span class="text-white">{{ __('general.nav.news') }}</span>
                    </li>
                </ol>
            </nav>
            <h1 class="font-serif text-4xl lg:text-5xl font-bold">{{ __('general.nav.news') }}</h1>
            <p class="mt-4 text-white/80 text-lg max-w-2xl">
                {{ __('general.home.events_intro') }}
            </p>
        </div>
    </section>

    {{-- Noticias Destacadas --}}
    @if($noticiasDestacadas->count() > 0)
        <section class="py-16 bg-gray-50">
            <div class="container-main">
                <h2 class="font-serif text-2xl lg:text-3xl font-bold text-gray-900 mb-8">
                    {{ __('general.news.featured') }}
                </h2>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    @foreach($noticiasDestacadas as $index => $destacada)
                        @if($index === 0)
                            {{-- Noticia principal grande --}}
                            <article class="lg:col-span-2 card group hover:shadow-xl transition-all duration-300 overflow-hidden">
                                <div class="aspect-video bg-gray-100 relative overflow-hidden">
                                    @if($destacada->imagen)
                                        <img src="{{ $destacada->imagen_url }}"
                                             alt="{{ $destacada->titulo }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary-100 to-primary-200">
                                            <svg class="w-20 h-20 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="absolute top-4 left-4">
                                        <span class="px-3 py-1 text-sm font-medium rounded-full bg-gold-500 text-white">
                                            {{ __('general.news.featured') }}
                                        </span>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <div class="flex items-center gap-3 mb-3">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-primary-100 text-primary-700">
                                            {{ $destacada->nombre_categoria }}
                                        </span>
                                        <span class="text-sm text-gray-500">{{ $destacada->fecha_formateada }}</span>
                                    </div>
                                    <h3 class="font-serif text-2xl font-bold text-gray-900 mb-3 group-hover:text-primary-600 transition-colors">
                                        <a href="{{ route('noticias.detalle', ['locale' => app()->getLocale(), 'slug' => $destacada->slug]) }}">
                                            {{ $destacada->titulo }}
                                        </a>
                                    </h3>
                                    @if($destacada->extracto)
                                        <p class="text-gray-600 line-clamp-3">{{ $destacada->extracto }}</p>
                                    @endif
                                    <a href="{{ route('noticias.detalle', ['locale' => app()->getLocale(), 'slug' => $destacada->slug]) }}"
                                       class="inline-flex items-center gap-1 text-primary-600 hover:text-primary-700 font-medium text-sm mt-4">
                                        {{ __('general.actions.read_more') }}
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </article>
                        @else
                            {{-- Noticias secundarias --}}
                            <article class="card group hover:shadow-lg transition-all duration-300 overflow-hidden">
                                <div class="aspect-video bg-gray-100 relative overflow-hidden">
                                    @if($destacada->imagen)
                                        <img src="{{ $destacada->imagen_url }}"
                                             alt="{{ $destacada->titulo }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary-100 to-primary-200">
                                            <svg class="w-12 h-12 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-xs text-gray-500">{{ $destacada->fecha_formateada }}</span>
                                    </div>
                                    <h3 class="font-semibold text-gray-900 group-hover:text-primary-600 transition-colors line-clamp-2">
                                        <a href="{{ route('noticias.detalle', ['locale' => app()->getLocale(), 'slug' => $destacada->slug]) }}">
                                            {{ $destacada->titulo }}
                                        </a>
                                    </h3>
                                </div>
                            </article>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Todas las Noticias --}}
    <section class="py-16 lg:py-24">
        <div class="container-main">
            <h2 class="font-serif text-2xl lg:text-3xl font-bold text-gray-900 mb-8">
                {{ __('general.news.all') }}
            </h2>

            @if($noticias->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($noticias as $noticia)
                        <article class="card group hover:shadow-xl transition-all duration-300 overflow-hidden">
                            {{-- Imagen --}}
                            <div class="aspect-video bg-gray-100 relative overflow-hidden">
                                @if($noticia->imagen)
                                    <img src="{{ $noticia->imagen_url }}"
                                         alt="{{ $noticia->titulo }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary-100 to-primary-200">
                                        <svg class="w-16 h-16 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                        </svg>
                                    </div>
                                @endif

                                {{-- Categoría badge --}}
                                <div class="absolute top-4 right-4">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full
                                        @switch($noticia->categoria)
                                            @case('parroquia') bg-primary-100 text-primary-700 @break
                                            @case('diocesis') bg-green-100 text-green-700 @break
                                            @case('papa') bg-yellow-100 text-yellow-700 @break
                                            @case('comunidad') bg-blue-100 text-blue-700 @break
                                            @default bg-gray-100 text-gray-700
                                        @endswitch
                                    ">
                                        {{ $noticia->nombre_categoria }}
                                    </span>
                                </div>

                                @if($noticia->es_destacado)
                                    <div class="absolute top-4 left-4">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-gold-500 text-white">
                                            {{ __('general.news.featured') }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            {{-- Contenido --}}
                            <div class="p-6">
                                <div class="flex items-center gap-3 text-sm text-gray-500 mb-3">
                                    <span>{{ $noticia->fecha_formateada }}</span>
                                    <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                    <span>{{ $noticia->tiempo_lectura }} {{ __('general.time.minutes_read') }}</span>
                                </div>

                                <h3 class="font-serif text-xl font-bold text-gray-900 mb-2 group-hover:text-primary-600 transition-colors">
                                    <a href="{{ route('noticias.detalle', ['locale' => app()->getLocale(), 'slug' => $noticia->slug]) }}">
                                        {{ $noticia->titulo }}
                                    </a>
                                </h3>

                                @if($noticia->extracto)
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                        {{ $noticia->extracto }}
                                    </p>
                                @endif

                                @if($noticia->autor)
                                    <p class="text-sm text-gray-500">
                                        Por <span class="font-medium text-gray-700">{{ $noticia->autor }}</span>
                                    </p>
                                @endif

                                <a href="{{ route('noticias.detalle', ['locale' => app()->getLocale(), 'slug' => $noticia->slug]) }}"
                                   class="inline-flex items-center gap-1 text-primary-600 hover:text-primary-700 font-medium text-sm mt-4">
                                    {{ __('general.actions.read_more') }}
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Paginación --}}
                @if($noticias->hasPages())
                    <div class="mt-12">
                        {{ $noticias->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-12 bg-gray-50 rounded-xl">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                    <p class="text-gray-500">{{ __('general.messages.no_news') }}</p>
                    <p class="text-gray-400 text-sm mt-2">{{ __('general.home.events_intro') }}</p>
                </div>
            @endif
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-12 bg-primary-900 text-white">
        <div class="container-main text-center">
            <h2 class="text-2xl font-bold mb-4">{{ __('general.news.stay_updated') }}</h2>
            <p class="text-white/80 mb-6">{{ __('general.footer.follow_us') }}</p>
            <a href="{{ route('contacto', ['locale' => app()->getLocale()]) }}" class="btn-primary bg-white text-primary-700 hover:bg-gray-100">
                {{ __('general.nav.contact') }}
            </a>
        </div>
    </section>
@endsection
