@extends('layouts.app')

@section('title', $evento->titulo . ' | ' . __('general.site.short_name'))
@section('description', $evento->descripcion_corta ?? 'Evento: ' . $evento->titulo)
@section('og_image', $evento->imagen ? asset('storage/' . $evento->imagen) : asset('images/og-default.jpg'))

@section('breadcrumbs')
    <x-breadcrumbs :items="[
        ['nombre' => __('general.nav.events'), 'url' => route('eventos.index', ['locale' => app()->getLocale()])],
        ['nombre' => $evento->titulo, 'url' => '']
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
                        <a href="{{ route('eventos.index', ['locale' => app()->getLocale()]) }}" class="hover:text-white">
                            {{ __('general.nav.events') }}
                        </a>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        <span class="text-white truncate max-w-[200px]">{{ $evento->titulo }}</span>
                    </li>
                </ol>
            </nav>

            <div class="flex items-center gap-3 mb-4">
                <span class="px-3 py-1 text-sm font-medium rounded-full bg-white/20">
                    {{ $evento->nombre_categoria }}
                </span>
                @if($evento->es_destacado)
                    <span class="px-3 py-1 text-sm font-medium rounded-full bg-gold-500 text-white">
                        Destacado
                    </span>
                @endif
            </div>

            <h1 class="font-serif text-4xl lg:text-5xl font-bold">{{ $evento->titulo }}</h1>

            @if($evento->descripcion_corta)
                <p class="mt-4 text-white/80 text-lg max-w-2xl">{{ $evento->descripcion_corta }}</p>
            @endif
        </div>
    </section>

    {{-- Contenido Principal --}}
    <section class="py-16 lg:py-24">
        <div class="container-main">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                {{-- Contenido --}}
                <div class="lg:col-span-2">
                    {{-- Imagen destacada --}}
                    @if($evento->imagen)
                        <div class="aspect-video rounded-xl overflow-hidden mb-8">
                            <img src="{{ $evento->imagen_url }}"
                                 alt="{{ $evento->titulo }}"
                                 class="w-full h-full object-cover">
                        </div>
                    @endif

                    {{-- Descripción --}}
                    @if($evento->descripcion)
                        <div class="prose prose-lg max-w-none">
                            {!! $evento->descripcion !!}
                        </div>
                    @endif
                </div>

                {{-- Sidebar --}}
                <aside class="lg:col-span-1">
                    <div class="card p-6 sticky top-24">
                        <h2 class="font-semibold text-lg text-gray-900 mb-4">Detalles del Evento</h2>

                        <dl class="space-y-4">
                            {{-- Fecha --}}
                            <div>
                                <dt class="text-sm text-gray-500 mb-1">Fecha</dt>
                                <dd class="flex items-center gap-2 text-gray-900 font-medium">
                                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $evento->fecha_formateada }}
                                </dd>
                            </div>

                            {{-- Horario --}}
                            @if($evento->horario_formateado)
                                <div>
                                    <dt class="text-sm text-gray-500 mb-1">Horario</dt>
                                    <dd class="flex items-center gap-2 text-gray-900">
                                        <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $evento->horario_formateado }}
                                    </dd>
                                </div>
                            @endif

                            {{-- Lugar --}}
                            @if($evento->lugar)
                                <div>
                                    <dt class="text-sm text-gray-500 mb-1">Lugar</dt>
                                    <dd class="flex items-center gap-2 text-gray-900">
                                        <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        {{ $evento->lugar }}
                                    </dd>
                                </div>
                            @endif

                            {{-- Dirección --}}
                            @if($evento->direccion)
                                <div>
                                    <dt class="text-sm text-gray-500 mb-1">Dirección</dt>
                                    <dd class="text-gray-700 text-sm">{{ $evento->direccion }}</dd>
                                </div>
                            @endif
                        </dl>

                        {{-- CTA --}}
                        <div class="mt-6 pt-6 border-t border-gray-100 space-y-3">
                            <a href="{{ route('contacto', ['locale' => app()->getLocale()]) }}"
                               class="btn-primary w-full text-center">
                                Más información
                            </a>
                            <a href="{{ route('eventos.index', ['locale' => app()->getLocale()]) }}"
                               class="block text-center text-primary-600 hover:text-primary-700 text-sm">
                                ← Ver todos los eventos
                            </a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    {{-- Otros Eventos --}}
    @if($otrosEventos->count() > 0)
        <section class="py-16 bg-gray-50">
            <div class="container-main">
                <h2 class="font-serif text-2xl lg:text-3xl font-bold text-gray-900 mb-8">
                    Otros eventos próximos
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($otrosEventos as $otroEvento)
                        <article class="card group hover:shadow-lg transition-shadow overflow-hidden">
                            <div class="aspect-video bg-gray-100 relative">
                                @if($otroEvento->imagen)
                                    <img src="{{ $otroEvento->imagen_url }}"
                                         alt="{{ $otroEvento->titulo }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary-100 to-primary-200">
                                        <svg class="w-12 h-12 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute top-3 left-3 bg-white rounded-lg shadow p-1.5 text-center min-w-[50px]">
                                    <div class="text-lg font-bold text-primary-600">{{ $otroEvento->fecha_inicio->format('d') }}</div>
                                    <div class="text-xs uppercase text-gray-500">{{ $otroEvento->fecha_inicio->translatedFormat('M') }}</div>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 group-hover:text-primary-600 transition-colors line-clamp-2">
                                    <a href="{{ route('eventos.detalle', ['locale' => app()->getLocale(), 'slug' => $otroEvento->slug]) }}">
                                        {{ $otroEvento->titulo }}
                                    </a>
                                </h3>
                                @if($otroEvento->lugar)
                                    <p class="text-sm text-gray-500 mt-1">{{ $otroEvento->lugar }}</p>
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
    "@context": "https://schema.org",
    "@type": "Event",
    "name": "{{ $evento->titulo }}",
    "description": "{{ $evento->descripcion_corta ?? Str::limit(strip_tags($evento->descripcion ?? ''), 160) }}",
    @if($evento->imagen)
    "image": "{{ asset('storage/' . $evento->imagen) }}",
    @endif
    "startDate": "{{ $evento->fecha_inicio->toIso8601String() }}",
    @if($evento->fecha_fin)
    "endDate": "{{ $evento->fecha_fin->toIso8601String() }}",
    @endif
    "location": {
        "@type": "Place",
        "name": "{{ $evento->lugar ?? __('general.site.name') }}",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "{{ $evento->direccion ?? '' }}",
            "addressLocality": "Tampico",
            "addressRegion": "Tamaulipas",
            "addressCountry": "MX"
        }
    },
    "organizer": {
        "@type": "Organization",
        "name": "{{ __('general.site.name') }}",
        "url": "{{ config('app.url') }}"
    },
    "eventStatus": "https://schema.org/EventScheduled",
    "eventAttendanceMode": "https://schema.org/OfflineEventAttendanceMode"
}
</script>
@endpush
