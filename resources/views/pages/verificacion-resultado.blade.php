@extends('layouts.app')

@section('title', __('general.verification.success_title') . ' | ' . __('general.site.short_name'))

@section('content')
    <section class="py-20">
        <div class="container-main">
            <div class="max-w-lg mx-auto">
                <div class="card p-8 text-center">
                    @if($tipo === 'success')
                        <div class="w-20 h-20 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                    @elseif($tipo === 'info')
                        <div class="w-20 h-20 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    @elseif($tipo === 'warning')
                        <div class="w-20 h-20 mx-auto bg-yellow-100 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                    @else
                        <div class="w-20 h-20 mx-auto bg-red-100 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                    @endif

                    <h1 class="text-2xl font-bold text-gray-900 mb-4">
                        @if($exito)
                            {{ __('general.verification.success_title') }}
                        @else
                            {{ __('general.verification.error_title') }}
                        @endif
                    </h1>

                    <p class="text-gray-600 mb-8">{{ $mensaje }}</p>

                    @if($exito && isset($fiel))
                        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-left">
                            <p class="text-sm text-gray-500 mb-2">{{ __('general.register.personal_info') }}:</p>
                            <p class="font-medium text-gray-900">{{ $fiel->nombre_completo }}</p>
                            <p class="text-gray-600">{{ $fiel->email }}</p>
                        </div>
                    @endif

                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <a href="{{ route('inicio', ['locale' => app()->getLocale()]) }}" class="btn-primary">
                            {{ __('general.nav.home') }}
                        </a>

                        @if(!$exito)
                            <a href="{{ route('registro', ['locale' => app()->getLocale()]) }}" class="btn-secondary">
                                {{ __('general.nav.register') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
