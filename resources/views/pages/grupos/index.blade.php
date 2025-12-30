@extends('layouts.app')

@section('title', __('general.nav.groups') . ' | ' . __('general.site.short_name'))

@section('content')
    <section class="bg-gradient-to-br from-primary-800 to-primary-900 text-white py-16">
        <div class="container-main">
            <h1 class="font-serif text-4xl lg:text-5xl font-bold">{{ __('general.nav.groups') }}</h1>
            <p class="mt-4 text-white/80 text-lg">Comunidades de fe donde puedes crecer espiritualmente junto a otros hermanos.</p>
        </div>
    </section>

    <section class="py-16">
        <div class="container-main">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach([
                    ['nombre' => 'Coro Parroquial', 'descripcion' => 'Ministerio de música que anima las celebraciones litúrgicas.', 'horario' => 'Ensayos: Miércoles 7:00 PM'],
                    ['nombre' => 'Catequesis', 'descripcion' => 'Formación en la fe para niños, jóvenes y adultos.', 'horario' => 'Sábados 10:00 AM'],
                    ['nombre' => 'Grupo de Jóvenes', 'descripcion' => 'Espacio de encuentro y crecimiento para jóvenes católicos.', 'horario' => 'Viernes 7:00 PM'],
                    ['nombre' => 'Matrimonios', 'descripcion' => 'Acompañamiento y formación para parejas casadas.', 'horario' => 'Sábados 5:00 PM'],
                    ['nombre' => 'Legión de María', 'descripcion' => 'Devoción mariana y apostolado.', 'horario' => 'Martes 6:00 PM'],
                    ['nombre' => 'Ministros de la Eucaristía', 'descripcion' => 'Servicio en la distribución de la comunión.', 'horario' => 'Según asignación'],
                ] as $grupo)
                <div class="card p-6 hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-lg text-gray-900 mb-2">{{ $grupo['nombre'] }}</h3>
                    <p class="text-gray-600 text-sm mb-4">{{ $grupo['descripcion'] }}</p>
                    <p class="text-primary-600 text-sm font-medium">{{ $grupo['horario'] }}</p>
                </div>
                @endforeach
            </div>

            <div class="mt-12 text-center">
                <p class="text-gray-600 mb-4">¿Interesado en unirte a algún grupo?</p>
                <a href="{{ route('contacto', ['locale' => app()->getLocale()]) }}" class="btn-primary">
                    Contáctanos
                </a>
            </div>
        </div>
    </section>
@endsection
