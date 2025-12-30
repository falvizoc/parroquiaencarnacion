@extends('layouts.app')

@section('title', $grupo->nombre . ' | ' . __('general.site.short_name'))
@section('description', $grupo->descripcion_corta ?? 'Conoce el grupo ' . $grupo->nombre . ' de la Parroquia Nuestra Señora de la Encarnación.')

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
                        <a href="{{ route('grupos.index', ['locale' => app()->getLocale()]) }}" class="hover:text-white">
                            {{ __('general.nav.groups') }}
                        </a>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        <span class="text-white">{{ $grupo->nombre }}</span>
                    </li>
                </ol>
            </nav>
            <h1 class="font-serif text-4xl lg:text-5xl font-bold">{{ $grupo->nombre }}</h1>
            @if($grupo->descripcion_corta)
                <p class="mt-4 text-white/80 text-lg max-w-2xl">{{ $grupo->descripcion_corta }}</p>
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
                    @if($grupo->imagen)
                        <div class="aspect-video rounded-xl overflow-hidden mb-8">
                            <img src="{{ $grupo->imagen_url }}"
                                 alt="{{ $grupo->nombre }}"
                                 class="w-full h-full object-cover">
                        </div>
                    @endif

                    {{-- Descripción --}}
                    @if($grupo->descripcion)
                        <div class="prose prose-lg max-w-none">
                            {!! $grupo->descripcion !!}
                        </div>
                    @endif
                </div>

                {{-- Sidebar --}}
                <aside class="lg:col-span-1">
                    {{-- Tarjeta de información --}}
                    <div class="card p-6 sticky top-24">
                        <h2 class="font-semibold text-lg text-gray-900 mb-4">Información del Grupo</h2>

                        <dl class="space-y-4">
                            {{-- Horario --}}
                            @if($grupo->horario_formateado)
                                <div>
                                    <dt class="text-sm text-gray-500 mb-1">Horario de reunión</dt>
                                    <dd class="flex items-center gap-2 text-gray-900">
                                        <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $grupo->horario_formateado }}
                                    </dd>
                                </div>
                            @endif

                            {{-- Lugar --}}
                            @if($grupo->lugar_reunion)
                                <div>
                                    <dt class="text-sm text-gray-500 mb-1">Lugar de reunión</dt>
                                    <dd class="flex items-center gap-2 text-gray-900">
                                        <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        {{ $grupo->lugar_reunion }}
                                    </dd>
                                </div>
                            @endif

                            {{-- Coordinador --}}
                            @if($grupo->coordinador_nombre)
                                <div class="pt-4 border-t border-gray-100">
                                    <dt class="text-sm text-gray-500 mb-1">Coordinador</dt>
                                    <dd class="text-gray-900 font-medium">{{ $grupo->coordinador_nombre }}</dd>

                                    @if($grupo->coordinador_telefono)
                                        <dd class="mt-2">
                                            <a href="tel:{{ $grupo->coordinador_telefono }}"
                                               class="inline-flex items-center gap-2 text-sm text-primary-600 hover:text-primary-700">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                                </svg>
                                                {{ $grupo->coordinador_telefono }}
                                            </a>
                                        </dd>
                                    @endif

                                    @if($grupo->coordinador_email)
                                        <dd class="mt-1">
                                            <a href="mailto:{{ $grupo->coordinador_email }}"
                                               class="inline-flex items-center gap-2 text-sm text-primary-600 hover:text-primary-700">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                </svg>
                                                {{ $grupo->coordinador_email }}
                                            </a>
                                        </dd>
                                    @endif
                                </div>
                            @endif
                        </dl>

                        {{-- CTA --}}
                        <div class="mt-6 pt-6 border-t border-gray-100">
                            <a href="{{ route('contacto', ['locale' => app()->getLocale()]) }}"
                               class="btn-primary w-full text-center">
                                Quiero unirme
                            </a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    {{-- Otros Grupos --}}
    @if($otrosGrupos->count() > 0)
        <section class="py-16 bg-gray-50">
            <div class="container-main">
                <h2 class="font-serif text-2xl lg:text-3xl font-bold text-gray-900 mb-8">
                    Otros grupos que te pueden interesar
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($otrosGrupos as $otroGrupo)
                        <article class="card group hover:shadow-lg transition-shadow">
                            <div class="aspect-video bg-gray-100 overflow-hidden">
                                @if($otroGrupo->imagen)
                                    <img src="{{ $otroGrupo->imagen_url }}"
                                         alt="{{ $otroGrupo->nombre }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary-100 to-primary-200">
                                        <svg class="w-12 h-12 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 group-hover:text-primary-600 transition-colors">
                                    <a href="{{ route('grupos.detalle', ['locale' => app()->getLocale(), 'slug' => $otroGrupo->slug]) }}">
                                        {{ $otroGrupo->nombre }}
                                    </a>
                                </h3>
                                @if($otroGrupo->horario_formateado)
                                    <p class="text-sm text-gray-500 mt-1">{{ $otroGrupo->horario_formateado }}</p>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
