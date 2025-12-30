@extends('layouts.app')

@section('title', 'Nuestra Parroquia | ' . __('general.site.short_name'))
@section('description', 'Conoce la historia, misión y valores de la Parroquia Nuestra Señora de la Encarnación en Tampico, Tamaulipas. Una comunidad católica de fe, esperanza y caridad.')

@section('breadcrumbs')
    <x-breadcrumbs :items="[
        ['nombre' => 'Nuestra Parroquia', 'url' => '']
    ]" />
@endsection

@section('content')
    {{-- Hero --}}
    <section class="bg-gradient-to-br from-primary-800 to-primary-900 text-white py-20">
        <div class="container-main text-center">
            <h1 class="font-serif text-4xl lg:text-5xl font-bold mb-4">Nuestra Parroquia</h1>
            <p class="text-xl text-white/80 max-w-2xl mx-auto">
                {{ __('general.site.tagline') }}
            </p>
        </div>
    </section>

    {{-- Sobre Nosotros --}}
    <section class="py-16 lg:py-24">
        <div class="container-main">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="font-serif text-3xl font-bold text-gray-900 mb-6">
                        Parroquia Nuestra Señora de la Encarnación
                    </h2>
                    <div class="prose prose-lg text-gray-600">
                        <p>
                            La Parroquia Nuestra Señora de la Encarnación es una comunidad católica ubicada en
                            Tampico, Tamaulipas, México. Pertenecemos a la Diócesis de Tampico y servimos a
                            nuestra comunidad con dedicación y amor pastoral.
                        </p>
                        <p>
                            Nuestra misión es evangelizar, celebrar los sacramentos y acompañar a los fieles
                            en su camino de fe. Contamos con diversos grupos parroquiales, programas de
                            formación y actividades pastorales para todas las edades.
                        </p>
                        <p>
                            El templo principal está dedicado a Nuestra Señora de la Encarnación, y
                            contamos con varias capillas filiales que extienden nuestra presencia pastoral
                            a diferentes colonias de la ciudad.
                        </p>
                    </div>
                </div>
                <div class="relative">
                    <div class="aspect-[4/3] rounded-2xl overflow-hidden bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                        <svg class="w-32 h-32 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Misión, Visión, Valores --}}
    <section class="py-16 bg-gray-50">
        <div class="container-main">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="card p-8 text-center">
                    <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="font-serif text-xl font-bold text-gray-900 mb-4">Nuestra Misión</h3>
                    <p class="text-gray-600">
                        Evangelizar y acompañar a nuestra comunidad en el encuentro personal con Cristo,
                        celebrando los sacramentos y viviendo la caridad cristiana.
                    </p>
                </div>

                <div class="card p-8 text-center">
                    <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <h3 class="font-serif text-xl font-bold text-gray-900 mb-4">Nuestra Visión</h3>
                    <p class="text-gray-600">
                        Ser una parroquia viva y misionera, donde cada fiel encuentre su lugar
                        para crecer en la fe y servir a los demás.
                    </p>
                </div>

                <div class="card p-8 text-center">
                    <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-serif text-xl font-bold text-gray-900 mb-4">Nuestros Valores</h3>
                    <p class="text-gray-600">
                        Fe, esperanza, caridad, comunidad, servicio, acogida, formación
                        y compromiso con el Evangelio.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Servicios --}}
    <section class="py-16">
        <div class="container-main">
            <h2 class="font-serif text-3xl font-bold text-gray-900 mb-8 text-center">Nuestros Servicios</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="card p-6">
                    <h3 class="font-semibold text-gray-900 mb-2">Celebración de Misas</h3>
                    <p class="text-sm text-gray-600 mb-4">Misas diarias y dominicales en el templo principal y capillas.</p>
                    <a href="{{ route('horarios', ['locale' => app()->getLocale()]) }}" class="text-primary-600 text-sm font-medium hover:underline">
                        Ver horarios →
                    </a>
                </div>

                <div class="card p-6">
                    <h3 class="font-semibold text-gray-900 mb-2">Sacramentos</h3>
                    <p class="text-sm text-gray-600 mb-4">Bautismo, Primera Comunión, Confirmación, Matrimonio y más.</p>
                    <a href="{{ route('contacto', ['locale' => app()->getLocale()]) }}" class="text-primary-600 text-sm font-medium hover:underline">
                        Más información →
                    </a>
                </div>

                <div class="card p-6">
                    <h3 class="font-semibold text-gray-900 mb-2">Formación</h3>
                    <p class="text-sm text-gray-600 mb-4">Catequesis, grupos de estudio bíblico y programas de formación.</p>
                    <a href="{{ route('grupos.index', ['locale' => app()->getLocale()]) }}" class="text-primary-600 text-sm font-medium hover:underline">
                        Ver grupos →
                    </a>
                </div>

                <div class="card p-6">
                    <h3 class="font-semibold text-gray-900 mb-2">Adoración Perpetua</h3>
                    <p class="text-sm text-gray-600 mb-4">Capilla de adoración al Santísimo Sacramento disponible 24/7.</p>
                    <a href="{{ route('adoracion', ['locale' => app()->getLocale()]) }}" class="text-primary-600 text-sm font-medium hover:underline">
                        Conocer más →
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <x-faq :items="[
        [
            'pregunta' => '¿Cuáles son los horarios de misa?',
            'respuesta' => 'Los horarios de misa varían según el día de la semana. Celebramos misas diarias en el templo principal y misas dominicales tanto en el templo como en nuestras capillas filiales. <a href=\"' . route('horarios', ['locale' => app()->getLocale()]) . '\" class=\"text-primary-600 hover:underline\">Consulte nuestros horarios actualizados</a>.'
        ],
        [
            'pregunta' => '¿Cómo puedo registrarme en la parroquia?',
            'respuesta' => 'Puede registrarse como fiel de nuestra parroquia a través del <a href=\"' . route('registro', ['locale' => app()->getLocale()]) . '\" class=\"text-primary-600 hover:underline\">formulario de registro en línea</a>. También puede acudir a las oficinas parroquiales en horario de atención.'
        ],
        [
            'pregunta' => '¿Qué documentos necesito para el bautizo?',
            'respuesta' => 'Para el sacramento del Bautismo necesita: acta de nacimiento del niño, identificación de los padres, y los padrinos deben presentar constancia de confirmación y certificado de pláticas pre-bautismales. Contacte la oficina parroquial para más detalles.'
        ],
        [
            'pregunta' => '¿Cómo puedo unirme a un grupo parroquial?',
            'respuesta' => 'Contamos con diversos grupos parroquiales para todas las edades e intereses. <a href=\"' . route('grupos.index', ['locale' => app()->getLocale()]) . '\" class=\"text-primary-600 hover:underline\">Consulte nuestra lista de grupos</a> y contacte al coordinador del grupo de su interés.'
        ],
        [
            'pregunta' => '¿Tienen capillas en otras colonias?',
            'respuesta' => 'Sí, contamos con varias capillas filiales que extienden nuestra presencia pastoral a diferentes zonas de la ciudad. <a href=\"' . route('capillas.index', ['locale' => app()->getLocale()]) . '\" class=\"text-primary-600 hover:underline\">Vea nuestras capillas y sus horarios</a>.'
        ],
        [
            'pregunta' => '¿Cómo puedo contactar a la parroquia?',
            'respuesta' => 'Puede contactarnos a través de nuestra <a href=\"' . route('contacto', ['locale' => app()->getLocale()]) . '\" class=\"text-primary-600 hover:underline\">página de contacto</a>, por teléfono en horario de oficina, o visitándonos personalmente en el templo.'
        ]
    ]" />

    {{-- CTA --}}
    <section class="py-16 bg-primary-900 text-white">
        <div class="container-main text-center">
            <h2 class="font-serif text-3xl font-bold mb-4">¿Desea formar parte de nuestra comunidad?</h2>
            <p class="text-white/80 mb-8 max-w-2xl mx-auto">
                Le invitamos a registrarse y mantenerse informado de nuestras actividades,
                eventos y noticias parroquiales.
            </p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="{{ route('registro', ['locale' => app()->getLocale()]) }}" class="btn-secondary">
                    Registrarse
                </a>
                <a href="{{ route('contacto', ['locale' => app()->getLocale()]) }}" class="btn-outline-white">
                    Contáctenos
                </a>
            </div>
        </div>
    </section>
@endsection

@push('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Church",
    "name": "{{ __('general.site.name') }}",
    "alternateName": "{{ __('general.site.short_name') }}",
    "description": "Parroquia católica en Tampico, Tamaulipas, México. Comunidad de fe, esperanza y caridad.",
    "url": "{{ config('app.url') }}",
    "logo": "{{ asset('images/logo.png') }}",
    "image": "{{ asset('images/og-default.jpg') }}",
    "address": {
        "@type": "PostalAddress",
        "addressLocality": "Tampico",
        "addressRegion": "Tamaulipas",
        "addressCountry": "MX"
    },
    "geo": {
        "@type": "GeoCoordinates",
        "latitude": "22.2475",
        "longitude": "-97.8508"
    },
    "parentOrganization": {
        "@type": "Organization",
        "name": "Diócesis de Tampico"
    },
    "sameAs": []
}
</script>
@endpush
