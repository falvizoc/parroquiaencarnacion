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
        <x-filament::section collapsible>
            <x-slot name="heading">
                Vista previa del Hero
            </x-slot>
            <x-slot name="description">
                Así se verá la sección Hero en la página de inicio (actualización en tiempo real)
            </x-slot>

            <div class="relative h-48 rounded-lg overflow-hidden" wire:key="hero-preview-{{ $heroPreviewUrl }}">
                @if($heroPreviewUrl)
                    <img src="{{ $heroPreviewUrl }}"
                         alt="Vista previa Hero"
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-black/60"></div>
                @else
                    <div class="w-full h-full bg-gradient-to-br from-primary-900 via-primary-800 to-primary-900 flex items-center justify-center">
                        <span class="text-white/60 text-sm">Sin imagen - se usará gradiente</span>
                    </div>
                @endif
                <div class="absolute inset-0 flex items-center p-6">
                    <div class="text-white">
                        <h3 class="text-xl font-bold font-serif">{{ __('general.site.name') }}</h3>
                        <p class="text-sm text-white/80 mt-1">{{ __('general.site.tagline') }}</p>
                        <div class="flex gap-2 mt-3">
                            <span class="px-3 py-1 text-xs bg-white text-primary-700 rounded-lg">
                                {{ $this->heroData['hero_cta_principal_texto'] ?? 'Ver Horarios' }}
                            </span>
                            <span class="px-3 py-1 text-xs border border-white text-white rounded-lg">
                                {{ $this->heroData['hero_cta_secundario_texto'] ?? 'Contacto' }}
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
        <x-filament::section collapsible>
            <x-slot name="heading">
                Vista previa de Adoración
            </x-slot>
            <x-slot name="description">
                Así se verá la sección de Adoración Perpetua (actualización en tiempo real)
            </x-slot>

            @php
                $posicionClase = match($adoracionPosicion) {
                    'top' => 'object-top',
                    'bottom' => 'object-bottom',
                    default => 'object-center',
                };
            @endphp
            <div class="relative h-40 rounded-lg overflow-hidden" wire:key="adoracion-preview-{{ $adoracionPreviewUrl }}-{{ $adoracionPosicion }}">
                @if($adoracionPreviewUrl)
                    <img src="{{ $adoracionPreviewUrl }}"
                         alt="Vista previa Adoración"
                         class="w-full h-full object-cover {{ $posicionClase }}">
                    <div class="absolute inset-0 bg-gradient-to-br from-amber-900/60 via-amber-800/50 to-amber-900/60"></div>
                    <div class="absolute inset-0 flex items-center justify-center text-center p-4">
                        <div class="text-white">
                            <h3 class="text-lg font-bold font-serif">Capilla de Adoración Perpetua</h3>
                            <p class="text-sm text-white/80 mt-1">Abierta las 24 horas</p>
                        </div>
                    </div>
                @else
                    <div class="w-full h-full bg-gradient-to-br from-amber-50 to-amber-100 flex items-center justify-center">
                        <div class="text-center text-gray-900">
                            <h3 class="text-lg font-bold font-serif">Capilla de Adoración Perpetua</h3>
                            <p class="text-sm text-gray-600 mt-1">Abierta las 24 horas</p>
                            <p class="text-xs text-gray-400 mt-2">Sin imagen - se usará gradiente dorado</p>
                        </div>
                    </div>
                @endif
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>
