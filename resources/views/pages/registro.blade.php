@extends('layouts.app')

@section('title', __('general.nav.register') . ' | ' . __('general.site.short_name'))

@section('content')
    <section class="bg-gradient-to-br from-primary-800 to-primary-900 text-white py-16">
        <div class="container-main">
            <h1 class="font-serif text-4xl lg:text-5xl font-bold">Registro de Fieles</h1>
            <p class="mt-4 text-white/80 text-lg">Únete a nuestra comunidad parroquial y mantente informado.</p>
        </div>
    </section>

    <section class="py-16">
        <div class="container-main">
            <div class="max-w-2xl mx-auto">
                <div class="card p-8">
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
                            ¡Gracias por registrarte! Te contactaremos pronto.
                        </div>
                    @endif

                    <form action="{{ route('registro.guardar', ['locale' => app()->getLocale()]) }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nombre(s) <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="nombre" name="nombre" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            </div>
                            <div>
                                <label for="apellidos" class="block text-sm font-medium text-gray-700 mb-2">
                                    Apellidos <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="apellidos" name="apellidos" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            </div>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Correo electrónico <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="email" name="email" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>

                        <div>
                            <label for="telefono" class="block text-sm font-medium text-gray-700 mb-2">
                                Teléfono
                            </label>
                            <input type="tel" id="telefono" name="telefono"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>

                        <div>
                            <label for="direccion" class="block text-sm font-medium text-gray-700 mb-2">
                                Dirección (Colonia)
                            </label>
                            <input type="text" id="direccion" name="direccion"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                ¿Cómo te gustaría participar?
                            </label>
                            <div class="space-y-2">
                                @foreach(['Asistir a misa regularmente', 'Unirme a un grupo parroquial', 'Voluntariado', 'Solo recibir información'] as $opcion)
                                <label class="flex items-center gap-3">
                                    <input type="checkbox" name="intereses[]" value="{{ $opcion }}"
                                        class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                                    <span class="text-gray-700">{{ $opcion }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <input type="checkbox" id="newsletter" name="newsletter" checked
                                class="mt-1 w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                            <label for="newsletter" class="text-sm text-gray-600">
                                Deseo recibir noticias y comunicaciones de la parroquia por correo electrónico.
                            </label>
                        </div>

                        <div class="flex items-start gap-3">
                            <input type="checkbox" id="privacidad" name="privacidad" required
                                class="mt-1 w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                            <label for="privacidad" class="text-sm text-gray-600">
                                He leído y acepto la <a href="#" class="text-primary-600 hover:underline">Política de Privacidad</a> <span class="text-red-500">*</span>
                            </label>
                        </div>

                        <button type="submit" class="btn-primary w-full">
                            Registrarme
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
