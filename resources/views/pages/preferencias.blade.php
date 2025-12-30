@extends('layouts.app')

@section('title', __('Preferencias de comunicación') . ' | ' . __('general.site.short_name'))

@section('content')
    <section class="bg-gradient-to-br from-primary-800 to-primary-900 text-white py-16">
        <div class="container-main">
            <h1 class="font-serif text-4xl lg:text-5xl font-bold">{{ __('Preferencias de comunicación') }}</h1>
            <p class="mt-4 text-white/80 text-lg">{{ __('Elige qué tipo de comunicaciones deseas recibir.') }}</p>
        </div>
    </section>

    <section class="py-16">
        <div class="container-main">
            @livewire('gestion-preferencias', ['token' => $token])
        </div>
    </section>
@endsection
