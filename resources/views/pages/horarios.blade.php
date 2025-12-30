@extends('layouts.app')

@section('title', __('general.nav.schedules') . ' | ' . __('general.site.short_name'))
@section('description', 'Horarios de misa en la Parroquia Nuestra Señora de la Encarnación. Misas diarias, dominicales y especiales en Tampico, Tamaulipas.')

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
                Aquí encontrarás todos los horarios de misa de nuestra parroquia.
            </p>
        </div>
    </section>

    {{-- Horarios --}}
    <section class="py-16 lg:py-24">
        <div class="container-main">
            {{-- Grid de días --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                {{-- Domingo (destacado) --}}
                <div class="lg:col-span-2 xl:col-span-1 card border-2 border-primary-200 bg-primary-50/50">
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 bg-primary-600 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-primary-900">Domingo</h2>
                                <p class="text-sm text-primary-600">Día del Señor</p>
                            </div>
                        </div>
                        <ul class="space-y-3">
                            <li class="flex items-center justify-between p-3 bg-white rounded-lg">
                                <div>
                                    <span class="font-semibold text-gray-900">8:00 AM</span>
                                    <span class="text-sm text-gray-500 block">Templo Principal</span>
                                </div>
                                <span class="text-xs bg-primary-100 text-primary-700 px-2 py-1 rounded">Dominical</span>
                            </li>
                            <li class="flex items-center justify-between p-3 bg-white rounded-lg">
                                <div>
                                    <span class="font-semibold text-gray-900">10:00 AM</span>
                                    <span class="text-sm text-gray-500 block">Templo Principal</span>
                                </div>
                                <span class="text-xs bg-gold-100 text-gold-700 px-2 py-1 rounded">Con coro</span>
                            </li>
                            <li class="flex items-center justify-between p-3 bg-white rounded-lg">
                                <div>
                                    <span class="font-semibold text-gray-900">12:00 PM</span>
                                    <span class="text-sm text-gray-500 block">Templo Principal</span>
                                </div>
                                <span class="text-xs bg-primary-100 text-primary-700 px-2 py-1 rounded">Dominical</span>
                            </li>
                            <li class="flex items-center justify-between p-3 bg-white rounded-lg">
                                <div>
                                    <span class="font-semibold text-gray-900">7:00 PM</span>
                                    <span class="text-sm text-gray-500 block">Templo Principal</span>
                                </div>
                                <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded">Vespertina</span>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Lunes a Viernes --}}
                @foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'] as $dia)
                <div class="card">
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <h2 class="text-lg font-bold text-gray-900">{{ $dia }}</h2>
                        </div>
                        <ul class="space-y-2">
                            <li class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <span class="font-semibold text-gray-900">7:00 AM</span>
                                    <span class="text-sm text-gray-500 block">Templo Principal</span>
                                </div>
                            </li>
                            <li class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <span class="font-semibold text-gray-900">7:00 PM</span>
                                    <span class="text-sm text-gray-500 block">Templo Principal</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                @endforeach

                {{-- Sábado --}}
                <div class="card border-2 border-gold-200 bg-gold-50/50">
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-gold-500 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-gray-900">Sábado</h2>
                                <p class="text-sm text-gold-600">Vigilia Dominical</p>
                            </div>
                        </div>
                        <ul class="space-y-2">
                            <li class="flex items-center justify-between p-3 bg-white rounded-lg">
                                <div>
                                    <span class="font-semibold text-gray-900">8:00 AM</span>
                                    <span class="text-sm text-gray-500 block">Templo Principal</span>
                                </div>
                            </li>
                            <li class="flex items-center justify-between p-3 bg-white rounded-lg">
                                <div>
                                    <span class="font-semibold text-gray-900">7:00 PM</span>
                                    <span class="text-sm text-gray-500 block">Templo Principal</span>
                                </div>
                                <span class="text-xs bg-gold-100 text-gold-700 px-2 py-1 rounded">Vigilia</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Notas --}}
            <div class="mt-12 p-6 bg-gray-50 rounded-xl">
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
        "@context": "https://schema.org",
        "@type": "Church",
        "name": "{{ __('general.site.name') }}",
        "event": [
            {
                "@type": "Event",
                "name": "Misa Dominical",
                "startDate": "{{ now()->next('Sunday')->format('Y-m-d') }}T08:00:00-06:00",
                "location": {
                    "@type": "Place",
                    "name": "Templo Principal"
                }
            }
        ]
    }
    </script>
    @endpush
@endsection
