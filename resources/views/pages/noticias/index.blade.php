@extends('layouts.app')

@section('title', __('general.nav.news') . ' | ' . __('general.site.short_name'))

@section('content')
    <section class="bg-gradient-to-br from-primary-800 to-primary-900 text-white py-16">
        <div class="container-main">
            <h1 class="font-serif text-4xl lg:text-5xl font-bold">{{ __('general.nav.news') }}</h1>
            <p class="mt-4 text-white/80 text-lg">Mantente informado sobre las actividades de nuestra parroquia.</p>
        </div>
    </section>

    <section class="py-16">
        <div class="container-main">
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Próximamente</h2>
                <p class="text-gray-600">Las noticias estarán disponibles cuando se integre el contenido de Facebook.</p>
            </div>
        </div>
    </section>
@endsection
