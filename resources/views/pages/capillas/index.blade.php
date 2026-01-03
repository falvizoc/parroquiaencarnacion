@extends('layouts.app')

@section('title', __('general.nav.chapels') . ' | ' . __('general.site.short_name'))
@section('description', 'Conoce las capillas de la Parroquia Nuestra Señora de la Encarnación en Tampico.')

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
                        <span class="text-white">{{ __('general.nav.chapels') }}</span>
                    </li>
                </ol>
            </nav>
            <h1 class="font-serif text-4xl lg:text-5xl font-bold">{{ __('general.chapels.title') }}</h1>
            <p class="mt-4 text-white/80 text-lg max-w-2xl">
                {{ __('general.chapels.intro') }}
            </p>
        </div>
    </section>

    {{-- Capillas --}}
    <section class="py-16 lg:py-24">
        <div class="container-main">
            @if($capillas->count() > 0)
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    @foreach($capillas as $capilla)
                        <article class="card group hover:shadow-xl transition-all duration-300 overflow-hidden">
                            <div class="md:flex">
                                {{-- Imagen --}}
                                <div class="md:w-2/5 aspect-video md:aspect-auto bg-gray-100 relative overflow-hidden">
                                    @if($capilla->imagen)
                                        <img src="{{ $capilla->imagen_url }}"
                                             alt="{{ $capilla->nombre }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full min-h-[200px] flex items-center justify-center bg-gradient-to-br from-primary-100 to-primary-200">
                                            <svg class="w-16 h-16 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                {{-- Contenido --}}
                                <div class="md:w-3/5 p-6">
                                    <h2 class="font-serif text-2xl font-bold text-gray-900 mb-3 group-hover:text-primary-600 transition-colors">
                                        <a href="{{ route('capillas.detalle', ['locale' => app()->getLocale(), 'slug' => $capilla->slug]) }}">
                                            {{ $capilla->nombre }}
                                        </a>
                                    </h2>

                                    @if($capilla->descripcion)
                                        <p class="text-gray-600 mb-4 line-clamp-3">
                                            {{ Str::limit(strip_tags($capilla->descripcion), 150) }}
                                        </p>
                                    @endif

                                    <div class="space-y-2 text-sm text-gray-500">
                                        @if($capilla->direccion)
                                            <div class="flex items-start gap-2">
                                                <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                                <span>{{ $capilla->direccion }}</span>
                                            </div>
                                        @endif

                                        @if($capilla->telefono)
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                                </svg>
                                                <a href="tel:{{ $capilla->telefono }}" class="hover:text-primary-600">{{ $capilla->telefono }}</a>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex items-center gap-4 mt-4 pt-4 border-t border-gray-100">
                                        <span class="text-sm text-gray-500">
                                            <strong class="text-gray-700">{{ $capilla->horarios_count }}</strong> {{ strtolower(__('general.chapels.mass_schedules')) }}
                                        </span>
                                        <span class="text-sm text-gray-500">
                                            <strong class="text-gray-700">{{ $capilla->grupos_count }}</strong> {{ strtolower(__('general.nav.groups')) }}
                                        </span>
                                    </div>

                                    <a href="{{ route('capillas.detalle', ['locale' => app()->getLocale(), 'slug' => $capilla->slug]) }}"
                                       class="inline-flex items-center gap-1 text-primary-600 hover:text-primary-700 font-medium text-sm mt-4">
                                        {{ __('general.actions.view_details') }}
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-gray-50 rounded-xl">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <p class="text-gray-500">{{ __('general.messages.no_chapels') }}</p>
                </div>
            @endif
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-12 bg-primary-900 text-white">
        <div class="container-main text-center">
            <h2 class="text-2xl font-bold mb-4">{{ __('general.chapels.need_more_info') }}</h2>
            <p class="text-white/80 mb-6">{{ __('general.groups.contact_info') }}</p>
            <a href="{{ route('contacto', ['locale' => app()->getLocale()]) }}" class="btn-primary bg-white text-primary-700 hover:bg-gray-100">
                {{ __('general.nav.contact') }}
            </a>
        </div>
    </section>
@endsection
