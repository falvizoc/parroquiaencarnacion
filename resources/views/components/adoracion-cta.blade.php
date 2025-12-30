@php
    use App\Models\Setting;
    use Illuminate\Support\Facades\Storage;

    $imagen_adoracion = Setting::obtener('adoracion_imagen');
    $efectos_activos = Setting::obtener('adoracion_efectos_activos', true);

    $tiene_imagen = !empty($imagen_adoracion);
@endphp

<section class="relative py-16 lg:py-24 overflow-hidden
               {{ !$tiene_imagen ? 'bg-gradient-to-br from-gold-50 to-gold-100' : '' }}">

    @if($tiene_imagen)
        {{-- Imagen de fondo --}}
        <div class="absolute inset-0 parallax-container">
            <div class="parallax-bg"
                 @if($efectos_activos) data-parallax="adoracion" @endif
                 style="background-image: url('{{ Storage::url($imagen_adoracion) }}');">
            </div>
        </div>

        {{-- Overlay dorado solemne --}}
        <div class="adoracion-overlay"></div>

        {{-- Shimmer dorado --}}
        @if($efectos_activos)
            <div class="gold-shimmer"></div>
        @endif
    @endif

    <div class="container-main relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            {{-- Icono --}}
            <div class="w-20 h-20 {{ $tiene_imagen ? 'bg-white/20' : 'bg-gold-200' }} rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 {{ $tiene_imagen ? 'text-white' : 'text-gold-700' }}" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
            </div>

            {{-- Título --}}
            <h2 class="font-serif text-3xl lg:text-4xl font-bold {{ $tiene_imagen ? 'text-white' : 'text-gray-900' }} mb-4">
                Capilla de Adoración Perpetua
            </h2>

            {{-- Descripción --}}
            <p class="{{ $tiene_imagen ? 'text-white/90' : 'text-gray-600' }} text-lg mb-8 max-w-2xl mx-auto">
                Nuestra capilla está abierta las 24 horas del día, los 7 días de la semana.
                Te invitamos a pasar un momento en presencia del Santísimo Sacramento.
            </p>

            {{-- CTA --}}
            <a href="{{ route('adoracion', ['locale' => app()->getLocale()]) }}"
               class="{{ $tiene_imagen ? 'btn-primary bg-white text-gold-700 hover:bg-gray-100' : 'btn-primary' }}">
                Conoce más sobre la Adoración
            </a>
        </div>
    </div>
</section>
