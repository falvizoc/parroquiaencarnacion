@extends('layouts.app')

@section('title', __('general.nav.schedules') . ' | ' . __('general.site.short_name'))
@section('description', 'Horarios de misa en la Parroquia Nuestra Señora de la Encarnación y sus capillas. Misas diarias, dominicales y especiales en Tampico, Tamaulipas.')

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
                        <span class="text-white">{{ __('general.nav.schedules') }}</span>
                    </li>
                </ol>
            </nav>
            <h1 class="font-serif text-4xl lg:text-5xl font-bold">
                {{ __('general.nav.schedules') }}
            </h1>
            <p class="mt-4 text-white/80 text-lg max-w-2xl">
                Te invitamos a participar en nuestras celebraciones eucarísticas.
                Aquí encontrarás todos los horarios de misa de nuestra parroquia y sus capillas.
            </p>
        </div>
    </section>

    {{-- Navegación rápida --}}
    <section class="py-6 bg-gray-50 border-b sticky top-16 lg:top-20 z-30">
        <div class="container-main">
            <div class="flex flex-wrap gap-3">
                <a href="#parroquia-principal" class="px-4 py-2 bg-primary-600 text-white rounded-full text-sm font-medium hover:bg-primary-700 transition-colors">
                    Templo Principal
                </a>
                @foreach($capillas as $capilla)
                    <a href="#{{ $capilla->slug }}" class="px-4 py-2 bg-white text-gray-700 rounded-full text-sm font-medium hover:bg-gray-100 transition-colors border">
                        {{ $capilla->nombre }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Parroquia Principal --}}
    <section id="parroquia-principal" class="py-16 lg:py-24 scroll-mt-32">
        <div class="container-main">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 bg-primary-600 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-serif text-2xl lg:text-3xl font-bold text-gray-900">Templo Principal</h2>
                    <p class="text-gray-600">Parroquia Nuestra Señora de la Encarnación</p>
                </div>
            </div>

            @php
                $diasSemana = [
                    0 => ['nombre' => 'Domingo', 'icono' => 'sun', 'destacado' => true],
                    1 => ['nombre' => 'Lunes', 'icono' => 'calendar', 'destacado' => false],
                    2 => ['nombre' => 'Martes', 'icono' => 'calendar', 'destacado' => false],
                    3 => ['nombre' => 'Miércoles', 'icono' => 'calendar', 'destacado' => false],
                    4 => ['nombre' => 'Jueves', 'icono' => 'calendar', 'destacado' => false],
                    5 => ['nombre' => 'Viernes', 'icono' => 'calendar', 'destacado' => false],
                    6 => ['nombre' => 'Sábado', 'icono' => 'moon', 'destacado' => true],
                ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($diasSemana as $numeroDia => $datoDia)
                    @php
                        $horariosDelDia = $horariosParroquia[$numeroDia] ?? collect();
                    @endphp
                    <div class="card {{ $datoDia['destacado'] ? 'border-2 border-primary-200 bg-primary-50/50' : '' }}">
                        <div class="p-6">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 {{ $datoDia['destacado'] ? 'bg-primary-600' : 'bg-gray-100' }} rounded-full flex items-center justify-center">
                                    @if($datoDia['icono'] === 'sun')
                                        <svg class="w-5 h-5 {{ $datoDia['destacado'] ? 'text-white' : 'text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                                        </svg>
                                    @elseif($datoDia['icono'] === 'moon')
                                        <svg class="w-5 h-5 {{ $datoDia['destacado'] ? 'text-white' : 'text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold {{ $datoDia['destacado'] ? 'text-primary-900' : 'text-gray-900' }}">
                                        {{ $datoDia['nombre'] }}
                                    </h3>
                                    @if($numeroDia === 0)
                                        <p class="text-sm text-primary-600">Día del Señor</p>
                                    @elseif($numeroDia === 6)
                                        <p class="text-sm text-gold-600">Vigilia Dominical</p>
                                    @endif
                                </div>
                            </div>

                            @if($horariosDelDia->count() > 0)
                                <ul class="space-y-2">
                                    @foreach($horariosDelDia as $horario)
                                        <li class="flex items-center justify-between p-3 {{ $datoDia['destacado'] ? 'bg-white' : 'bg-gray-50' }} rounded-lg">
                                            <div>
                                                <span class="font-semibold text-gray-900">{{ $horario->hora->format('H:i') }}</span>
                                                @if($horario->descripcion)
                                                    <span class="text-sm text-gray-500 block">{{ $horario->descripcion }}</span>
                                                @endif
                                            </div>
                                            @if($horario->tipo !== 'ordinaria')
                                                <span class="text-xs px-2 py-1 rounded {{ $horario->tipo === 'dominical' ? 'bg-primary-100 text-primary-700' : ($horario->tipo === 'vespertina' ? 'bg-gray-100 text-gray-700' : 'bg-gold-100 text-gold-700') }}">
                                                    {{ $horario->nombre_tipo }}
                                                </span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-gray-500 text-sm italic">No hay misas programadas</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Capillas --}}
    @foreach($capillas as $capilla)
        <section id="{{ $capilla->slug }}" class="py-16 lg:py-24 {{ $loop->even ? 'bg-gray-50' : '' }} scroll-mt-32">
            <div class="container-main">
                <div class="flex flex-col lg:flex-row lg:items-start gap-8">
                    {{-- Info de la capilla --}}
                    <div class="lg:w-1/3">
                        <div class="lg:sticky lg:top-40">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <h2 class="font-serif text-2xl lg:text-3xl font-bold text-gray-900">{{ $capilla->nombre }}</h2>
                            </div>

                            @if($capilla->direccion)
                                <div class="flex items-start gap-2 text-gray-600 mb-2">
                                    <svg class="w-5 h-5 text-gray-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span class="text-sm">{{ $capilla->direccion }}</span>
                                </div>
                            @endif

                            @if($capilla->telefono)
                                <div class="flex items-center gap-2 text-gray-600 mb-4">
                                    <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <a href="tel:{{ $capilla->telefono }}" class="text-sm hover:text-primary-600">{{ $capilla->telefono }}</a>
                                </div>
                            @endif

                            <a href="{{ route('capillas.detalle', ['locale' => app()->getLocale(), 'slug' => $capilla->slug]) }}" class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-700 text-sm font-medium">
                                Ver más información
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    {{-- Horarios de la capilla --}}
                    <div class="lg:w-2/3">
                        @php
                            $horariosCapilla = $capilla->massSchedules->groupBy('dia_semana');
                        @endphp

                        @if($capilla->massSchedules->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($diasSemana as $numeroDia => $datoDia)
                                    @php
                                        $horariosDelDia = $horariosCapilla[$numeroDia] ?? collect();
                                    @endphp
                                    @if($horariosDelDia->count() > 0)
                                        <div class="card p-4">
                                            <h4 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                                                @if($numeroDia === 0)
                                                    <span class="w-2 h-2 bg-primary-500 rounded-full"></span>
                                                @elseif($numeroDia === 6)
                                                    <span class="w-2 h-2 bg-gold-500 rounded-full"></span>
                                                @else
                                                    <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                                                @endif
                                                {{ $datoDia['nombre'] }}
                                            </h4>
                                            <ul class="space-y-2">
                                                @foreach($horariosDelDia as $horario)
                                                    <li class="flex items-center justify-between text-sm">
                                                        <span class="font-medium text-gray-900">{{ $horario->hora->format('H:i') }}</span>
                                                        @if($horario->descripcion)
                                                            <span class="text-gray-500 text-xs">{{ Str::limit($horario->descripcion, 20) }}</span>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <div class="bg-gray-100 rounded-lg p-6 text-center">
                                <p class="text-gray-500">No hay horarios de misa registrados para esta capilla.</p>
                                <p class="text-sm text-gray-400 mt-1">Contacta a la parroquia para más información.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endforeach

    {{-- Notas --}}
    <section class="py-12 bg-white">
        <div class="container-main">
            <div class="p-6 bg-gray-50 rounded-xl">
                <h3 class="font-semibold text-gray-900 mb-3">Notas importantes</h3>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-primary-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Las confesiones están disponibles 30 minutos antes de cada misa.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-primary-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Los horarios pueden variar en días festivos y celebraciones especiales.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-primary-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Para misas especiales (bodas, quinceañeras, difuntos) favor de contactar la oficina parroquial.</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    {{-- CTA Contacto --}}
    <section class="py-12 bg-primary-900 text-white">
        <div class="container-main text-center">
            <h2 class="text-2xl font-bold mb-4">¿Tienes alguna pregunta?</h2>
            <p class="text-white/80 mb-6">Contáctanos para más información sobre horarios o servicios especiales.</p>
            <a href="{{ route('contacto', ['locale' => app()->getLocale()]) }}" class="btn-primary bg-white text-primary-700 hover:bg-gray-100">
                {{ __('general.nav.contact') }}
            </a>
        </div>
    </section>

    {{-- Schema.org para horarios --}}
    @push('schema')
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "Church",
        "name": "{{ __('general.site.name') }}",
        "event": [
            {
                "@@type": "Event",
                "name": "Misa Dominical",
                "startDate": "{{ now()->next('Sunday')->format('Y-m-d') }}T08:00:00-06:00",
                "location": {
                    "@@type": "Place",
                    "name": "Templo Principal"
                }
            }
        ]
    }
    </script>
    @endpush
@endsection
