@extends('layouts.app')

@section('title', 'Nuestros Sacerdotes | ' . __('general.site.short_name'))
@section('description', 'Conoce a los sacerdotes de la Parroquia Nuestra Señora de la Encarnación en Tampico.')

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
                        <span class="text-white">Nuestros Sacerdotes</span>
                    </li>
                </ol>
            </nav>
            <h1 class="font-serif text-4xl lg:text-5xl font-bold">Nuestros Sacerdotes</h1>
            <p class="mt-4 text-white/80 text-lg max-w-2xl">
                Conoce a los sacerdotes que sirven a nuestra comunidad parroquial con dedicación y amor pastoral.
            </p>
        </div>
    </section>

    {{-- Párroco --}}
    @if($parroco)
        <section class="py-16 lg:py-24">
            <div class="container-main">
                <div class="card overflow-hidden">
                    <div class="lg:flex">
                        {{-- Foto --}}
                        <div class="lg:w-1/3">
                            @if($parroco->foto)
                                <img src="{{ $parroco->foto_url }}"
                                     alt="{{ $parroco->nombre_completo }}"
                                     class="w-full h-full object-cover min-h-[400px]">
                            @else
                                <div class="w-full h-full min-h-[400px] bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                                    <svg class="w-32 h-32 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        {{-- Contenido --}}
                        <div class="lg:w-2/3 p-8 lg:p-12">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="px-3 py-1 text-sm font-medium rounded-full bg-gold-100 text-gold-700">
                                    {{ $parroco->nombre_cargo }}
                                </span>
                            </div>

                            <h2 class="font-serif text-3xl lg:text-4xl font-bold text-gray-900 mb-2">
                                {{ $parroco->nombre_completo }}
                            </h2>

                            @if($parroco->fecha_asignacion)
                                <p class="text-gray-500 mb-6">
                                    Párroco desde {{ $parroco->fecha_asignacion->translatedFormat('F \\d\\e Y') }}
                                </p>
                            @endif

                            @if($parroco->mensaje)
                                <div class="prose prose-lg max-w-none mb-8 text-gray-600">
                                    {!! $parroco->mensaje !!}
                                </div>
                            @endif

                            @if($parroco->biografia)
                                <div class="bg-gray-50 rounded-lg p-6">
                                    <h3 class="font-semibold text-gray-900 mb-2">Biografía</h3>
                                    <p class="text-gray-600">{{ $parroco->biografia }}</p>
                                </div>
                            @endif

                            <div class="flex flex-wrap gap-4 mt-8">
                                @if($parroco->email)
                                    <a href="mailto:{{ $parroco->email }}"
                                       class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        {{ $parroco->email }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Vicarios --}}
    @if($vicarios->count() > 0)
        <section class="py-16 bg-gray-50">
            <div class="container-main">
                <h2 class="font-serif text-2xl lg:text-3xl font-bold text-gray-900 mb-8 text-center">
                    Vicarios Parroquiales
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($vicarios as $vicario)
                        <article class="card overflow-hidden group">
                            {{-- Foto --}}
                            <div class="aspect-[3/4] bg-gray-100 relative overflow-hidden">
                                @if($vicario->foto)
                                    <img src="{{ $vicario->foto_url }}"
                                         alt="{{ $vicario->nombre_completo }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary-100 to-primary-200">
                                        <svg class="w-24 h-24 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute top-4 left-4">
                                    <span class="px-3 py-1 text-sm font-medium rounded-full bg-white/90 text-primary-700">
                                        {{ $vicario->nombre_cargo }}
                                    </span>
                                </div>
                            </div>

                            {{-- Contenido --}}
                            <div class="p-6">
                                <h3 class="font-serif text-xl font-bold text-gray-900 mb-2">
                                    {{ $vicario->nombre_completo }}
                                </h3>

                                @if($vicario->fecha_asignacion)
                                    <p class="text-sm text-gray-500 mb-4">
                                        Desde {{ $vicario->fecha_asignacion->translatedFormat('F Y') }}
                                    </p>
                                @endif

                                @if($vicario->mensaje)
                                    <div class="prose prose-sm max-w-none text-gray-600 line-clamp-4">
                                        {!! Str::limit(strip_tags($vicario->mensaje), 200) !!}
                                    </div>
                                @endif

                                @if($vicario->email)
                                    <a href="mailto:{{ $vicario->email }}"
                                       class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-700 text-sm mt-4">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        Contactar
                                    </a>
                                @endif
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
            <h2 class="text-2xl font-bold mb-4">¿Necesitas hablar con un sacerdote?</h2>
            <p class="text-white/80 mb-6">Puedes agendar una cita o visitar la oficina parroquial.</p>
            <a href="{{ route('contacto', ['locale' => app()->getLocale()]) }}" class="btn-primary bg-white text-primary-700 hover:bg-gray-100">
                {{ __('general.nav.contact') }}
            </a>
        </div>
    </section>
@endsection
