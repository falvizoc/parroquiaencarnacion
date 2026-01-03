@extends('layouts.app')

@section('title', __('general.nav.register') . ' | ' . __('general.site.short_name'))

@section('content')
    <section class="bg-gradient-to-br from-primary-800 to-primary-900 text-white py-16">
        <div class="container-main">
            <h1 class="font-serif text-4xl lg:text-5xl font-bold">{{ __('general.register.title') }}</h1>
            <p class="mt-4 text-white/80 text-lg">{{ __('general.register.intro') }}</p>
        </div>
    </section>

    <section class="py-16">
        <div class="container-main">
            <div class="max-w-2xl mx-auto">
                @livewire('registro-fiel')
            </div>
        </div>
    </section>
@endsection
