<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Sección Analytics --}}
        <form wire:submit="guardarAnalytics">
            {{ $this->analyticsForm }}

            <div class="mt-4">
                <x-filament::button type="submit">
                    Guardar Configuración
                </x-filament::button>
            </div>
        </form>

        {{-- Información de ayuda Analytics --}}
        <x-filament::section collapsible collapsed>
            <x-slot name="heading">
                Cómo configurar Google Analytics 4
            </x-slot>

            <div class="prose prose-sm dark:prose-invert max-w-none">
                <ol>
                    <li>
                        <strong>Crear propiedad GA4:</strong>
                        <ul>
                            <li>Ve a <a href="https://analytics.google.com" target="_blank" class="text-primary-600 hover:underline">analytics.google.com</a></li>
                            <li>Crea una nueva propiedad GA4</li>
                            <li>Copia el <strong>Measurement ID</strong> (formato: G-XXXXXXXXXX)</li>
                        </ul>
                    </li>
                    <li>
                        <strong>Verificar Search Console:</strong>
                        <ul>
                            <li>Ve a <a href="https://search.google.com/search-console" target="_blank" class="text-primary-600 hover:underline">search.google.com/search-console</a></li>
                            <li>Añade tu propiedad</li>
                            <li>Copia el contenido del meta tag de verificación</li>
                        </ul>
                    </li>
                </ol>
            </div>
        </x-filament::section>

        <hr class="border-gray-200 dark:border-gray-700">

        {{-- Sección Facebook --}}
        <form wire:submit="guardarFacebook">
            {{ $this->facebookForm }}

            <div class="mt-4 flex gap-3">
                <x-filament::button type="submit">
                    Guardar Configuración
                </x-filament::button>

                <x-filament::button
                    type="button"
                    color="gray"
                    wire:click="probarConexionFacebook"
                >
                    Probar Conexión
                </x-filament::button>
            </div>
        </form>

        {{-- Información de ayuda Facebook --}}
        <x-filament::section collapsible collapsed>
            <x-slot name="heading">
                Cómo obtener las credenciales de Facebook
            </x-slot>

            <div class="prose prose-sm dark:prose-invert max-w-none">
                <ol>
                    <li>
                        <strong>Crear una App de Facebook:</strong>
                        <ul>
                            <li>Ve a <a href="https://developers.facebook.com" target="_blank" class="text-primary-600 hover:underline">developers.facebook.com</a></li>
                            <li>Crea una nueva app de tipo "Business"</li>
                            <li>Copia el <strong>App ID</strong> y <strong>App Secret</strong></li>
                        </ul>
                    </li>
                    <li>
                        <strong>Obtener el Page ID:</strong>
                        <ul>
                            <li>Ve a tu página de Facebook</li>
                            <li>Haz clic en "Información" o "About"</li>
                            <li>El Page ID aparece en la parte inferior</li>
                        </ul>
                    </li>
                    <li>
                        <strong>Generar Access Token:</strong>
                        <ul>
                            <li>En tu App de Facebook, ve a "Herramientas" > "Graph API Explorer"</li>
                            <li>Selecciona tu página y genera un token con permisos:
                                <code class="text-xs">pages_read_engagement</code>,
                                <code class="text-xs">pages_read_user_content</code>
                            </li>
                            <li>Extiende el token a uno de larga duración (60 días)</li>
                        </ul>
                    </li>
                </ol>

                <x-filament::link
                    href="https://developers.facebook.com/docs/pages/access-tokens"
                    target="_blank"
                    icon="heroicon-o-arrow-top-right-on-square"
                >
                    Documentación oficial de Facebook
                </x-filament::link>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>
