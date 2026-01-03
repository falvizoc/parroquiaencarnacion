<x-filament-panels::page>
    {{-- Navegación por Tabs (usando componente estándar) --}}
    <x-admin.tabs>
        {{-- Tab Identidad --}}
        <x-admin.tabs.item :active="$activeTab === 'identidad'" wire:click="$set('activeTab', 'identidad')">
            <x-slot:icon>
                <x-heroicon-o-building-library class="h-5 w-5" />
            </x-slot:icon>
            Identidad
        </x-admin.tabs.item>

        {{-- Tab Hero --}}
        <x-admin.tabs.item :active="$activeTab === 'hero'" wire:click="$set('activeTab', 'hero')">
            <x-slot:icon>
                <x-heroicon-o-photo class="h-5 w-5" />
            </x-slot:icon>
            Hero (Inicio)
        </x-admin.tabs.item>

        {{-- Tab Adoración --}}
        <x-admin.tabs.item :active="$activeTab === 'adoracion'" wire:click="$set('activeTab', 'adoracion')">
            <x-slot:icon>
                <x-heroicon-o-sparkles class="h-5 w-5" />
            </x-slot:icon>
            Adoración
        </x-admin.tabs.item>
    </x-admin.tabs>

    <div class="mt-6">
        {{-- Contenido Identidad --}}
        @if($activeTab === 'identidad')
            <div class="space-y-6">
                <form wire:submit="guardarIdentidad">
                    {{ $this->identidadForm }}

                    <div class="mt-4">
                        <x-filament::button type="submit">
                            Guardar Identidad
                        </x-filament::button>
                    </div>
                </form>

                {{-- Vista previa Logotipo --}}
                <x-filament::section collapsible collapsed>
                    <x-slot name="heading">
                        Vista previa del Logotipo
                    </x-slot>
                    <x-slot name="description">
                        Así se verá el logotipo en el encabezado y pie de página
                    </x-slot>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Preview en header claro --}}
                        <div class="p-4 bg-white rounded-lg border" wire:key="logo-preview-light-{{ $logotipoPreviewUrl }}">
                            <p class="text-xs text-gray-500 mb-3">En fondo claro (header):</p>
                            <div class="flex items-center gap-3">
                                @if($logotipoPreviewUrl)
                                    <img src="{{ $logotipoPreviewUrl }}"
                                         alt="Logotipo"
                                         class="w-12 h-12 object-contain">
                                @else
                                    <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                                        </svg>
                                    </div>
                                @endif
                                <div>
                                    <div class="font-serif font-bold text-gray-900 leading-tight">
                                        {{ $this->identidadData['nombre_parroquia'] ?? 'Parroquia Nuestra Señora de la Encarnación' }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $this->identidadData['ubicacion'] ?? 'Tampico, Tamaulipas, México' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Preview en footer oscuro --}}
                        <div class="p-4 bg-primary-950 rounded-lg" wire:key="logo-preview-dark-{{ $logotipoPreviewUrl }}">
                            <p class="text-xs text-white/50 mb-3">En fondo oscuro (footer):</p>
                            <div class="flex items-center gap-3 mb-2">
                                @if($logotipoPreviewUrl)
                                    <img src="{{ $logotipoPreviewUrl }}"
                                         alt="Logotipo"
                                         class="w-12 h-12 object-contain">
                                @else
                                    <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center">
                                        <svg class="w-8 h-8 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                                        </svg>
                                    </div>
                                @endif
                                <div>
                                    <div class="font-serif font-bold text-white leading-tight">
                                        {{ $this->identidadData['nombre_parroquia'] ?? 'Parroquia Nuestra Señora de la Encarnación' }}
                                    </div>
                                </div>
                            </div>
                            <p class="text-xs text-white/70 mb-2">
                                {{ $this->identidadData['slogan'] ?? 'Comunidad de fe, esperanza y caridad' }}
                            </p>
                            <div class="text-xs text-white/60 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                                {{ $this->identidadData['ubicacion'] ?? 'Tampico, Tamaulipas, México' }}
                            </div>
                        </div>
                    </div>

                    {{-- Preview Favicon --}}
                    @if($faviconPreviewUrl)
                        <div class="mt-4 pt-4 border-t">
                            <p class="text-xs text-gray-500 mb-2">Favicon (pestaña del navegador):</p>
                            <div class="flex items-center gap-3 p-2 bg-gray-100 rounded-lg inline-flex">
                                <img src="{{ $faviconPreviewUrl }}"
                                     alt="Favicon"
                                     class="w-4 h-4 object-contain">
                                <span class="text-sm text-gray-700">{{ $this->identidadData['nombre_parroquia'] ?? 'Parroquia...' }} | Tab del navegador</span>
                                <span class="text-gray-400">×</span>
                            </div>
                        </div>
                    @endif
                </x-filament::section>
            </div>
        @endif

        {{-- Contenido Hero --}}
        @if($activeTab === 'hero')
            <div class="space-y-6">
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
            </div>
        @endif

        {{-- Contenido Adoración --}}
        @if($activeTab === 'adoracion')
            <div class="space-y-6">
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
        @endif
    </div>
</x-filament-panels::page>
