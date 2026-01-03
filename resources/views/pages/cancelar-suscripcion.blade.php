@extends('layouts.app')

@section('title', __('general.unsubscribe.title') . ' | ' . __('general.site.short_name'))

@section('content')
    <section class="bg-gradient-to-br from-primary-800 to-primary-900 text-white py-16">
        <div class="container-main">
            <h1 class="font-serif text-4xl lg:text-5xl font-bold">{{ __('general.unsubscribe.title') }}</h1>
        </div>
    </section>

    <section class="py-16">
        <div class="container-main">
            <div class="max-w-lg mx-auto">
                @if($exito)
                    <div class="bg-white rounded-xl shadow-lg p-8 text-center">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ __('general.unsubscribe.title') }}</h2>
                        <p class="text-gray-600 mb-6">
                            {{ __('general.unsubscribe.message') }}
                        </p>
                        <p class="text-sm text-gray-500 mb-8">
                            {{ __('general.unsubscribe.change_mind') }}
                        </p>
                        <a
                            href="{{ route('newsletter', ['locale' => app()->getLocale()]) }}"
                            class="inline-block bg-amber-600 hover:bg-amber-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors"
                        >
                            {{ __('general.actions.resubscribe') }}
                        </a>
                    </div>
                @else
                    <div class="bg-red-50 border border-red-200 rounded-xl p-8 text-center">
                        <svg class="w-16 h-16 text-red-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <h2 class="text-2xl font-bold text-red-800 mb-4">{{ __('general.unsubscribe.invalid_title') }}</h2>
                        <p class="text-red-700">
                            {{ __('general.unsubscribe.invalid_message') }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
