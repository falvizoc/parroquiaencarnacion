@extends('layouts.app')

@section('title', __('general.nav.events') . ' | ' . __('general.site.short_name'))

@section('content')
    <section class="bg-gradient-to-br from-primary-800 to-primary-900 text-white py-16">
        <div class="container-main">
            <h1 class="font-serif text-4xl lg:text-5xl font-bold">{{ __('general.nav.events') }}</h1>
            <p class="mt-4 text-white/80 text-lg">Calendario de actividades y celebraciones de nuestra comunidad.</p>
        </div>
    </section>

    <section class="py-16">
        <div class="container-main">
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Próximamente</h2>
                <p class="text-gray-600">El calendario de eventos estará disponible cuando se complete la integración.</p>
            </div>
        </div>
    </section>
@endsection
