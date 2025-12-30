@extends('layouts.app')

@section('title', __('Newsletter') . ' | ' . __('general.site.short_name'))

@section('content')
    <section class="bg-gradient-to-br from-primary-800 to-primary-900 text-white py-16">
        <div class="container-main">
            <h1 class="font-serif text-4xl lg:text-5xl font-bold">{{ __('Suscríbete a nuestro Newsletter') }}</h1>
            <p class="mt-4 text-white/80 text-lg">{{ __('Recibe noticias, eventos y reflexiones directamente en tu correo.') }}</p>
        </div>
    </section>

    <section class="py-16">
        <div class="container-main">
            <div class="max-w-md mx-auto">
                <div class="bg-white rounded-xl shadow-lg p-8">
                    @livewire('suscripcion-newsletter')
                </div>

                <div class="mt-8 text-center text-gray-500 text-sm">
                    <p>¿Ya tienes una cuenta completa?</p>
                    <a href="{{ route('registro', ['locale' => app()->getLocale()]) }}" class="text-amber-600 hover:text-amber-700 font-medium">
                        Regístrate como fiel
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
