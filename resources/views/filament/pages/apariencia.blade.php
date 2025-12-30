<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Sección Hero --}}
        <form wire:submit="guardarHero">
            {{ $this->heroForm }}

            <div class="mt-4">
                <x-filament::button type="submit">
                    Guardar Configuración Hero
                </x-filament::button>
            </div>
        </form>

        {{-- Vista previa Hero --}}
        <x-filament::section collapsible collapsed>
            <x-slot name="heading">
                Vista previa del Hero
            </x-slot>
            <x-slot name="description">
                Así se verá la sección Hero en la página de inicio
            </x-slot>

            <div class="relative h-48 rounded-lg overflow-hidden">
                @php
                    $heroImagen = \App\Models\Setting::obtener('hero_imagen');
                @endphp
                @if($heroImagen)
                    <img src="{{ Storage::url($heroImagen) }}"
                         alt="Vista previa Hero"
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-black/60"></div>
                @else
                    <div class="w-full h-full bg-gradient-to-br from-primary-900 via-primary-800 to-primary-900"></div>
                @endif
                <div class="absolute inset-0 flex items-center p-6">
                    <div class="text-white">
                        <h3 class="text-xl font-bold font-serif">{{ __('general.site.name') }}</h3>
                        <p class="text-sm text-white/80 mt-1">{{ __('general.site.tagline') }}</p>
                        <div class="flex gap-2 mt-3">
                            @php
                                $ctaPrincipal = \App\Models\Setting::obtener('hero_cta_principal', []);
                                $ctaSecundario = \App\Models\Setting::obtener('hero_cta_secundario', []);
                            @endphp
                            <span class="px-3 py-1 text-xs bg-white text-primary-700 rounded-lg">
                                {{ $ctaPrincipal['texto'] ?? 'Ver Horarios' }}
                            </span>
                            <span class="px-3 py-1 text-xs border border-white text-white rounded-lg">
                                {{ $ctaSecundario['texto'] ?? 'Contacto' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </x-filament::section>

        <hr class="border-gray-200 dark:border-gray-700">

        {{-- Sección Adoración --}}
        <form wire:submit="guardarAdoracion">
            {{ $this->adoracionForm }}

            <div class="mt-4">
                <x-filament::button type="submit">
                    Guardar Configuración Adoración
                </x-filament::button>
            </div>
        </form>

        {{-- Vista previa Adoración --}}
        <x-filament::section collapsible collapsed>
            <x-slot name="heading">
                Vista previa de Adoración
            </x-slot>
            <x-slot name="description">
                Así se verá la sección de Adoración Perpetua
            </x-slot>

            <div class="relative h-32 rounded-lg overflow-hidden">
                @php
                    $adoracionImagen = \App\Models\Setting::obtener('adoracion_imagen');
                @endphp
                @if($adoracionImagen)
                    <img src="{{ Storage::url($adoracionImagen) }}"
                         alt="Vista previa Adoración"
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-br from-amber-900/70 via-amber-800/60 to-amber-900/70"></div>
                @else
                    <div class="w-full h-full bg-gradient-to-br from-amber-50 to-amber-100"></div>
                @endif
                <div class="absolute inset-0 flex items-center justify-center text-center p-4">
                    <div class="{{ $adoracionImagen ? 'text-white' : 'text-gray-900' }}">
                        <h3 class="text-lg font-bold font-serif">Capilla de Adoración Perpetua</h3>
                        <p class="text-sm {{ $adoracionImagen ? 'text-white/80' : 'text-gray-600' }} mt-1">
                            Abierta las 24 horas
                        </p>
                    </div>
                </div>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>
