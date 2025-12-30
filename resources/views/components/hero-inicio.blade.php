@php
    use App\Models\Setting;
    use Illuminate\Support\Facades\Storage;

    $imagen_hero = Setting::obtener('hero_imagen');
    $cta_principal = Setting::obtener('hero_cta_principal', []);
    $cta_secundario = Setting::obtener('hero_cta_secundario', []);
    $efectos_activos = Setting::obtener('hero_efectos_activos', true);

    $tiene_imagen = !empty($imagen_hero);
@endphp

<section class="relative text-white overflow-hidden min-h-[500px] lg:min-h-[600px] flex items-center
               {{ !$tiene_imagen ? 'bg-gradient-to-br from-primary-900 via-primary-800 to-primary-900' : '' }}">

    @if($tiene_imagen)
        {{-- Imagen de fondo con parallax --}}
        <div class="absolute inset-0 parallax-container">
            <div class="parallax-bg"
                 @if($efectos_activos) data-parallax="hero" @endif
                 style="background-image: url('{{ Storage::url($imagen_hero) }}');">
            </div>
        </div>

        {{-- Overlay oscuro con gradiente solemne --}}
        <div class="hero-overlay"></div>

        {{-- Efecto de luz sutil (shimmer) --}}
        @if($efectos_activos)
            <div class="light-shimmer"></div>
        @endif
    @else
        {{-- Patrón de cruces SVG (fallback sin imagen) --}}
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.4\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>
    @endif

    {{-- Contenido --}}
    <div class="container-main relative py-20 lg:py-32 z-10"
         @if($efectos_activos) data-fade-scroll="hero" @endif>
        <div class="max-w-3xl hero-content-animate">
            <h1 class="font-serif text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                {{ __('general.site.name') }}
            </h1>
            <p class="text-xl md:text-2xl text-white/90 mb-8">
                {{ __('general.site.tagline') }}
            </p>
            <div class="flex flex-wrap gap-4">
                {{-- Botón Principal --}}
                @if(!empty($cta_principal['texto']) && !empty($cta_principal['url']))
                    <a href="{{ $cta_principal['url'] }}"
                       class="btn-primary bg-white text-primary-700 hover:bg-gray-100">
                        {{ $cta_principal['texto'] }}
                    </a>
                @else
                    <a href="{{ route('horarios', ['locale' => app()->getLocale()]) }}"
                       class="btn-primary bg-white text-primary-700 hover:bg-gray-100">
                        {{ __('general.nav.schedules') }}
                    </a>
                @endif

                {{-- Botón Secundario --}}
                @if(!empty($cta_secundario['texto']) && !empty($cta_secundario['url']))
                    <a href="{{ $cta_secundario['url'] }}"
                       class="inline-flex items-center justify-center px-6 py-3 font-medium rounded-lg border-2 border-white text-white bg-transparent hover:bg-white/10 focus:ring-4 focus:ring-white/30 transition-colors duration-200">
                        {{ $cta_secundario['texto'] }}
                    </a>
                @else
                    <a href="{{ route('contacto', ['locale' => app()->getLocale()]) }}"
                       class="inline-flex items-center justify-center px-6 py-3 font-medium rounded-lg border-2 border-white text-white bg-transparent hover:bg-white/10 focus:ring-4 focus:ring-white/30 transition-colors duration-200">
                        {{ __('general.nav.contact') }}
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Wave Divider --}}
    <div class="absolute -bottom-px left-0 right-0 z-20 overflow-hidden">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-16 lg:h-24 block">
            <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H0Z" class="fill-gray-50"/>
        </svg>
    </div>
</section>
