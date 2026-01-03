@extends('layouts.app')

@section('title', __('general.nav.contact') . ' | ' . __('general.site.short_name'))
@section('description', 'Contacta a la Parroquia Nuestra Señora de la Encarnación. Dirección, teléfono, horarios de oficina y formulario de contacto.')

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
                        <span class="text-white">{{ __('general.nav.contact') }}</span>
                    </li>
                </ol>
            </nav>
            <h1 class="font-serif text-4xl lg:text-5xl font-bold">
                {{ __('general.nav.contact') }}
            </h1>
            <p class="mt-4 text-white/80 text-lg max-w-2xl">
                {{ __('general.about.intro') }}
            </p>
        </div>
    </section>

    {{-- Contenido --}}
    <section class="py-16 lg:py-24">
        <div class="container-main">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                {{-- Información de Contacto --}}
                <div class="lg:col-span-1">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ __('general.contact.info_title') }}</h2>

                    <div class="space-y-6">
                        {{-- Dirección --}}
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ __('general.contact.address') }}</h3>
                                <p class="text-gray-600 mt-1">
                                    Calle Ejemplo #123<br>
                                    Col. Centro<br>
                                    Tampico, Tamaulipas, México<br>
                                    C.P. 89000
                                </p>
                            </div>
                        </div>

                        {{-- Teléfono --}}
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ __('general.contact.phone') }}</h3>
                                <p class="text-gray-600 mt-1">
                                    <a href="tel:+528331234567" class="hover:text-primary-600">(833) 123-4567</a>
                                </p>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ __('general.contact.email') }}</h3>
                                <p class="text-gray-600 mt-1">
                                    <a href="mailto:contacto@parroquiaencarnaciontampico.org" class="hover:text-primary-600">
                                        contacto@parroquiaencarnaciontampico.org
                                    </a>
                                </p>
                            </div>
                        </div>

                        {{-- Horario de Oficina --}}
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ __('general.contact.office_hours') }}</h3>
                                <p class="text-gray-600 mt-1">
                                    Lunes a Viernes: 9:00 AM - 2:00 PM y 4:00 PM - 7:00 PM<br>
                                    Sábado: 9:00 AM - 1:00 PM<br>
                                    Domingo: Cerrado
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Redes Sociales --}}
                    <div class="mt-8">
                        <h3 class="font-semibold text-gray-900 mb-4">{{ __('general.footer.follow_us') }}</h3>
                        <div class="flex gap-3">
                            <a href="#" class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 hover:bg-primary-200 transition-colors" aria-label="Facebook">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            <a href="#" class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 hover:bg-primary-200 transition-colors" aria-label="YouTube">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Formulario de Contacto --}}
                <div class="lg:col-span-2">
                    <div class="card p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ __('general.contact.send_message_title') }}</h2>

                        @if(session('success'))
                            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('contacto.enviar', ['locale' => app()->getLocale()]) }}" method="POST" class="space-y-6">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ __('general.contact.form_name') }} <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        id="nombre"
                                        name="nombre"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                                        placeholder="Tu nombre"
                                    >
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ __('general.contact.form_email') }} <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                                        placeholder="tu@email.com"
                                    >
                                </div>
                            </div>

                            <div>
                                <label for="telefono" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('general.contact.phone') }}
                                </label>
                                <input
                                    type="tel"
                                    id="telefono"
                                    name="telefono"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                                    placeholder="(833) 000-0000"
                                >
                            </div>

                            <div>
                                <label for="asunto" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('general.contact.form_subject') }} <span class="text-red-500">*</span>
                                </label>
                                <select
                                    id="asunto"
                                    name="asunto"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                                >
                                    <option value="">{{ __('general.contact.select_subject') }}</option>
                                    <option value="informacion">{{ __('general.contact.subject_general') }}</option>
                                    <option value="sacramentos">{{ __('general.contact.subject_sacraments') }}</option>
                                    <option value="grupos">{{ __('general.contact.subject_groups') }}</option>
                                    <option value="eventos">{{ __('general.contact.subject_events') }}</option>
                                    <option value="adorador">{{ __('general.contact.subject_adorer') }}</option>
                                    <option value="otro">{{ __('general.contact.subject_other') }}</option>
                                </select>
                            </div>

                            <div>
                                <label for="mensaje" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('general.contact.form_message') }} <span class="text-red-500">*</span>
                                </label>
                                <textarea
                                    id="mensaje"
                                    name="mensaje"
                                    required
                                    rows="5"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors resize-none"
                                    placeholder="Escribe tu mensaje aquí..."
                                ></textarea>
                            </div>

                            <div class="flex items-start gap-3">
                                <input
                                    type="checkbox"
                                    id="privacidad"
                                    name="privacidad"
                                    required
                                    class="mt-1 w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500"
                                >
                                <label for="privacidad" class="text-sm text-gray-600">
                                    {{ __('general.contact.privacy_notice') }} <a href="#" class="text-primary-600 hover:underline">{{ __('general.footer.privacy') }}</a>
                                </label>
                            </div>

                            <button type="submit" class="btn-primary w-full md:w-auto">
                                {{ __('general.actions.send_message') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Mapa --}}
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ __('general.contact.location') }}</h2>
                <div class="card overflow-hidden">
                    <div class="aspect-video bg-gray-200 flex items-center justify-center">
                        {{-- Placeholder para el mapa --}}
                        <div class="text-center text-gray-500">
                            <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <p>{{ __('general.contact.map_placeholder') }}</p>
                            <p class="text-sm">(Se integrará en producción)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
