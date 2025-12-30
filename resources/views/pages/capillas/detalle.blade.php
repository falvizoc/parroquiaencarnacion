@extends('layouts.app')

@section('title', $capilla->nombre . ' | ' . __('general.site.short_name'))
@section('description', Str::limit(strip_tags($capilla->descripcion), 160) ?? 'Capilla ' . $capilla->nombre)

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
                        <a href="{{ route('capillas.index', ['locale' => app()->getLocale()]) }}" class="hover:text-white">
                            Capillas
                        </a>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        <span class="text-white truncate max-w-[200px]">{{ $capilla->nombre }}</span>
                    </li>
                </ol>
            </nav>

            <h1 class="font-serif text-4xl lg:text-5xl font-bold">{{ $capilla->nombre }}</h1>

            @if($capilla->direccion)
                <div class="flex items-center gap-2 mt-4 text-white/80">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>{{ $capilla->direccion }}</span>
                </div>
            @endif
        </div>
    </section>

    {{-- Contenido Principal --}}
    <section class="py-16 lg:py-24">
        <div class="container-main">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                {{-- Contenido --}}
                <div class="lg:col-span-2">
                    {{-- Imagen --}}
                    @if($capilla->imagen)
                        <div class="aspect-video rounded-xl overflow-hidden mb-8">
                            <img src="{{ $capilla->imagen_url }}"
                                 alt="{{ $capilla->nombre }}"
                                 class="w-full h-full object-cover">
                        </div>
                    @endif

                    {{-- Descripción --}}
                    @if($capilla->descripcion)
                        <div class="prose prose-lg max-w-none mb-12">
                            {!! $capilla->descripcion !!}
                        </div>
                    @endif

                    {{-- Horarios de Misa --}}
                    @if($horarios->count() > 0)
                        <div class="mb-12">
                            <h2 class="font-serif text-2xl font-bold text-gray-900 mb-6">Horarios de Misa</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($horarios->groupBy('dia_semana') as $dia => $horariosDia)
                                    <div class="card p-4">
                                        <h3 class="font-semibold text-primary-600 mb-2">
                                            {{ \App\Models\MassSchedule::DIAS_SEMANA[$dia] ?? 'Día' }}
                                        </h3>
                                        <ul class="space-y-1">
                                            @foreach($horariosDia as $horario)
                                                <li class="flex items-center gap-2 text-gray-600">
                                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <span>{{ $horario->hora_formateada }}</span>
                                                    @if($horario->descripcion)
                                                        <span class="text-gray-400">- {{ $horario->descripcion }}</span>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Grupos Parroquiales --}}
                    @if($grupos->count() > 0)
                        <div>
                            <h2 class="font-serif text-2xl font-bold text-gray-900 mb-6">Grupos Parroquiales</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($grupos as $grupo)
                                    <a href="{{ route('grupos.detalle', ['locale' => app()->getLocale(), 'slug' => $grupo->slug]) }}"
                                       class="card p-4 hover:shadow-lg transition-shadow group">
                                        <div class="flex items-center gap-4">
                                            @if($grupo->imagen)
                                                <img src="{{ $grupo->imagen_url }}"
                                                     alt="{{ $grupo->nombre }}"
                                                     class="w-16 h-16 rounded-full object-cover">
                                            @else
                                                <div class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div>
                                                <h3 class="font-semibold text-gray-900 group-hover:text-primary-600 transition-colors">
                                                    {{ $grupo->nombre }}
                                                </h3>
                                                @if($grupo->horario_formateado)
                                                    <p class="text-sm text-gray-500">{{ $grupo->horario_formateado }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Sidebar --}}
                <aside class="lg:col-span-1">
                    <div class="sticky top-24 space-y-6">
                        {{-- Información de Contacto --}}
                        <div class="card p-6">
                            <h3 class="font-semibold text-lg text-gray-900 mb-4">Información de Contacto</h3>
                            <dl class="space-y-4">
                                @if($capilla->direccion)
                                    <div>
                                        <dt class="text-sm text-gray-500 mb-1">Dirección</dt>
                                        <dd class="flex items-start gap-2 text-gray-900">
                                            <svg class="w-5 h-5 text-primary-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            <span>{{ $capilla->direccion }}</span>
                                        </dd>
                                    </div>
                                @endif

                                @if($capilla->telefono)
                                    <div>
                                        <dt class="text-sm text-gray-500 mb-1">Teléfono</dt>
                                        <dd class="flex items-center gap-2 text-gray-900">
                                            <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                            <a href="tel:{{ $capilla->telefono }}" class="hover:text-primary-600">{{ $capilla->telefono }}</a>
                                        </dd>
                                    </div>
                                @endif

                                @if($capilla->email)
                                    <div>
                                        <dt class="text-sm text-gray-500 mb-1">Correo</dt>
                                        <dd class="flex items-center gap-2 text-gray-900">
                                            <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                            <a href="mailto:{{ $capilla->email }}" class="hover:text-primary-600 break-all">{{ $capilla->email }}</a>
                                        </dd>
                                    </div>
                                @endif
                            </dl>
                        </div>

                        {{-- Mapa --}}
                        @if($capilla->mapa_url)
                            <div class="card overflow-hidden">
                                <iframe src="{{ $capilla->mapa_url }}"
                                        width="100%"
                                        height="250"
                                        style="border:0;"
                                        allowfullscreen=""
                                        loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            </div>
                        @endif

                        {{-- Volver --}}
                        <a href="{{ route('capillas.index', ['locale' => app()->getLocale()]) }}"
                           class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-700 font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Ver todas las capillas
                        </a>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    {{-- Otras Capillas --}}
    @if($otrasCapillas->count() > 0)
        <section class="py-16 bg-gray-50">
            <div class="container-main">
                <h2 class="font-serif text-2xl lg:text-3xl font-bold text-gray-900 mb-8">
                    Otras Capillas
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($otrasCapillas as $otraCapilla)
                        <article class="card group hover:shadow-lg transition-shadow overflow-hidden">
                            <div class="aspect-video bg-gray-100 relative">
                                @if($otraCapilla->imagen)
                                    <img src="{{ $otraCapilla->imagen_url }}"
                                         alt="{{ $otraCapilla->nombre }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary-100 to-primary-200">
                                        <svg class="w-12 h-12 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 group-hover:text-primary-600 transition-colors">
                                    <a href="{{ route('capillas.detalle', ['locale' => app()->getLocale(), 'slug' => $otraCapilla->slug]) }}">
                                        {{ $otraCapilla->nombre }}
                                    </a>
                                </h3>
                                @if($otraCapilla->direccion)
                                    <p class="text-sm text-gray-500 mt-1">{{ Str::limit($otraCapilla->direccion, 40) }}</p>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
