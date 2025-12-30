@extends('layouts.app')

@section('title', $noticia->titulo . ' | ' . __('general.site.short_name'))
@section('description', $noticia->extracto ?? 'Noticia: ' . $noticia->titulo)
@section('og_image', $noticia->imagen ? asset('storage/' . $noticia->imagen) : asset('images/og-default.jpg'))

@section('breadcrumbs')
    <x-breadcrumbs :items="[
        ['nombre' => __('general.nav.news'), 'url' => route('noticias.index', ['locale' => app()->getLocale()])],
        ['nombre' => $noticia->titulo, 'url' => '']
    ]" />
@endsection

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
                        <a href="{{ route('noticias.index', ['locale' => app()->getLocale()]) }}" class="hover:text-white">
                            {{ __('general.nav.news') }}
                        </a>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        <span class="text-white truncate max-w-[200px]">{{ $noticia->titulo }}</span>
                    </li>
                </ol>
            </nav>

            <div class="flex items-center gap-3 mb-4">
                <span class="px-3 py-1 text-sm font-medium rounded-full
                    @switch($noticia->categoria)
                        @case('parroquia') bg-primary-600/50 @break
                        @case('diocesis') bg-green-600/50 @break
                        @case('papa') bg-yellow-600/50 @break
                        @case('comunidad') bg-blue-600/50 @break
                        @default bg-white/20
                    @endswitch
                ">
                    {{ $noticia->nombre_categoria }}
                </span>
                @if($noticia->es_destacado)
                    <span class="px-3 py-1 text-sm font-medium rounded-full bg-gold-500 text-white">
                        Destacado
                    </span>
                @endif
            </div>

            <h1 class="font-serif text-3xl lg:text-5xl font-bold max-w-4xl">{{ $noticia->titulo }}</h1>

            <div class="flex flex-wrap items-center gap-4 mt-6 text-white/70">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>{{ $noticia->fecha_formateada }}</span>
                </div>
                @if($noticia->autor)
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>{{ $noticia->autor }}</span>
                    </div>
                @endif
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ $noticia->tiempo_lectura }} min de lectura</span>
                </div>
            </div>
        </div>
    </section>

    {{-- Contenido Principal --}}
    <section class="py-16 lg:py-24">
        <div class="container-main">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                {{-- Contenido --}}
                <article class="lg:col-span-2">
                    {{-- Imagen destacada --}}
                    @if($noticia->imagen)
                        <div class="aspect-video rounded-xl overflow-hidden mb-8">
                            <img src="{{ $noticia->imagen_url }}"
                                 alt="{{ $noticia->titulo }}"
                                 class="w-full h-full object-cover">
                        </div>
                    @endif

                    {{-- Extracto --}}
                    @if($noticia->extracto)
                        <div class="text-xl text-gray-600 mb-8 pb-8 border-b border-gray-200 font-medium">
                            {{ $noticia->extracto }}
                        </div>
                    @endif

                    {{-- Contenido --}}
                    <div class="prose prose-lg max-w-none">
                        {!! $noticia->contenido !!}
                    </div>

                    {{-- Compartir --}}
                    <div class="mt-12 pt-8 border-t border-gray-200">
                        <h4 class="font-semibold text-gray-900 mb-4">Compartir esta noticia</h4>
                        <div class="flex items-center gap-3">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="w-10 h-10 flex items-center justify-center rounded-full bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($noticia->titulo) }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="w-10 h-10 flex items-center justify-center rounded-full bg-black text-white hover:bg-gray-800 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                </svg>
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($noticia->titulo . ' - ' . request()->url()) }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="w-10 h-10 flex items-center justify-center rounded-full bg-green-500 text-white hover:bg-green-600 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                            </a>
                            <button onclick="navigator.clipboard.writeText('{{ request()->url() }}')"
                                    class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-200 text-gray-600 hover:bg-gray-300 transition-colors"
                                    title="Copiar enlace">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </article>

                {{-- Sidebar --}}
                <aside class="lg:col-span-1">
                    <div class="sticky top-24 space-y-8">
                        {{-- Info Card --}}
                        <div class="card p-6">
                            <h3 class="font-semibold text-lg text-gray-900 mb-4">Información</h3>
                            <dl class="space-y-4">
                                <div>
                                    <dt class="text-sm text-gray-500 mb-1">Categoría</dt>
                                    <dd class="font-medium text-gray-900">{{ $noticia->nombre_categoria }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500 mb-1">Fecha de publicación</dt>
                                    <dd class="font-medium text-gray-900">{{ $noticia->fecha_formateada }}</dd>
                                </div>
                                @if($noticia->autor)
                                    <div>
                                        <dt class="text-sm text-gray-500 mb-1">Autor</dt>
                                        <dd class="font-medium text-gray-900">{{ $noticia->autor }}</dd>
                                    </div>
                                @endif
                                <div>
                                    <dt class="text-sm text-gray-500 mb-1">Tiempo de lectura</dt>
                                    <dd class="font-medium text-gray-900">{{ $noticia->tiempo_lectura }} min</dd>
                                </div>
                            </dl>
                        </div>

                        {{-- CTA --}}
                        <div class="card p-6 bg-primary-50 border-primary-100">
                            <h3 class="font-semibold text-lg text-gray-900 mb-2">¿Tienes alguna pregunta?</h3>
                            <p class="text-sm text-gray-600 mb-4">
                                Contáctanos para más información sobre esta noticia u otras actividades parroquiales.
                            </p>
                            <a href="{{ route('contacto', ['locale' => app()->getLocale()]) }}"
                               class="btn-primary w-full text-center">
                                Contáctanos
                            </a>
                        </div>

                        {{-- Volver --}}
                        <a href="{{ route('noticias.index', ['locale' => app()->getLocale()]) }}"
                           class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-700 font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Ver todas las noticias
                        </a>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    {{-- Otras Noticias --}}
    @if($otrasNoticias->count() > 0)
        <section class="py-16 bg-gray-50">
            <div class="container-main">
                <h2 class="font-serif text-2xl lg:text-3xl font-bold text-gray-900 mb-8">
                    Más noticias
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($otrasNoticias as $otraNoticia)
                        <article class="card group hover:shadow-lg transition-shadow overflow-hidden">
                            <div class="aspect-video bg-gray-100 relative">
                                @if($otraNoticia->imagen)
                                    <img src="{{ $otraNoticia->imagen_url }}"
                                         alt="{{ $otraNoticia->titulo }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary-100 to-primary-200">
                                        <svg class="w-12 h-12 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute top-3 right-3">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-white/90 text-gray-700">
                                        {{ $otraNoticia->nombre_categoria }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-4">
                                <p class="text-xs text-gray-500 mb-2">{{ $otraNoticia->fecha_formateada }}</p>
                                <h3 class="font-semibold text-gray-900 group-hover:text-primary-600 transition-colors line-clamp-2">
                                    <a href="{{ route('noticias.detalle', ['locale' => app()->getLocale(), 'slug' => $otraNoticia->slug]) }}">
                                        {{ $otraNoticia->titulo }}
                                    </a>
                                </h3>
                                @if($otraNoticia->extracto)
                                    <p class="text-sm text-gray-500 mt-2 line-clamp-2">{{ $otraNoticia->extracto }}</p>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection

@push('schema')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "NewsArticle",
    "headline": "{{ $noticia->titulo }}",
    "description": "{{ $noticia->extracto ?? Str::limit(strip_tags($noticia->contenido), 160) }}",
    @if($noticia->imagen)
    "image": "{{ asset('storage/' . $noticia->imagen) }}",
    @endif
    "datePublished": "{{ $noticia->fecha_publicacion->toIso8601String() }}",
    "dateModified": "{{ $noticia->updated_at->toIso8601String() }}",
    "author": {
        "@@type": "Organization",
        "name": "{{ __('general.site.name') }}"
    },
    "publisher": {
        "@@type": "Organization",
        "name": "{{ __('general.site.name') }}",
        "logo": {
            "@@type": "ImageObject",
            "url": "{{ asset('images/logo.png') }}"
        }
    },
    "mainEntityOfPage": {
        "@@type": "WebPage",
        "@@id": "{{ url()->current() }}"
    }
}
</script>
@endpush
