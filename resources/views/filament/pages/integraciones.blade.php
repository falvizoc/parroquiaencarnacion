<x-filament-panels::page>
    {{-- Navegación por Tabs (usando componente estándar) --}}
    <x-admin.tabs>
        {{-- Tab: OpenAI / IA --}}
        <x-admin.tabs.item :active="$activeTab === 'ia'" wire:click="setActiveTab('ia')">
            <x-slot:icon>
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M22.2819 9.8211a5.9847 5.9847 0 0 0-.5157-4.9108 6.0462 6.0462 0 0 0-6.5098-2.9A6.0651 6.0651 0 0 0 4.9807 4.1818a5.9847 5.9847 0 0 0-3.9977 2.9 6.0462 6.0462 0 0 0 .7427 7.0966 5.98 5.98 0 0 0 .511 4.9107 6.051 6.051 0 0 0 6.5146 2.9001A5.9847 5.9847 0 0 0 13.2599 24a6.0557 6.0557 0 0 0 5.7718-4.2058 5.9894 5.9894 0 0 0 3.9977-2.9001 6.0557 6.0557 0 0 0-.7475-7.0729zm-9.022 12.6081a4.4755 4.4755 0 0 1-2.8764-1.0408l.1419-.0804 4.7783-2.7582a.7948.7948 0 0 0 .3927-.6813v-6.7369l2.02 1.1686a.071.071 0 0 1 .038.052v5.5826a4.504 4.504 0 0 1-4.4945 4.4944zm-9.6607-4.1254a4.4708 4.4708 0 0 1-.5346-3.0137l.142.0852 4.783 2.7582a.7712.7712 0 0 0 .7806 0l5.8428-3.3685v2.3324a.0804.0804 0 0 1-.0332.0615L9.74 19.9502a4.4992 4.4992 0 0 1-6.1408-1.6464zM2.3408 7.8956a4.485 4.485 0 0 1 2.3655-1.9728V11.6a.7664.7664 0 0 0 .3879.6765l5.8144 3.3543-2.0201 1.1685a.0757.0757 0 0 1-.071 0l-4.8303-2.7865A4.504 4.504 0 0 1 2.3408 7.8956zm16.5963 3.8558L13.1038 8.364 15.1192 7.2a.0757.0757 0 0 1 .071 0l4.8303 2.7913a4.4944 4.4944 0 0 1-.6765 8.1042v-5.6772a.79.79 0 0 0-.407-.667zm2.0107-3.0231l-.142-.0852-4.7735-2.7818a.7759.7759 0 0 0-.7854 0L9.409 9.2297V6.8974a.0662.0662 0 0 1 .0284-.0615l4.8303-2.7866a4.4992 4.4992 0 0 1 6.6802 4.66zM8.3065 12.863l-2.02-1.1638a.0804.0804 0 0 1-.038-.0567V6.0742a4.4992 4.4992 0 0 1 7.3757-3.4537l-.142.0805L8.704 5.459a.7948.7948 0 0 0-.3927.6813zm1.0976-2.3654l2.602-1.4998 2.6069 1.4998v2.9994l-2.5974 1.4997-2.6067-1.4997Z"/>
                </svg>
            </x-slot:icon>
            OpenAI
        </x-admin.tabs.item>

        {{-- Tab: Google Analytics --}}
        <x-admin.tabs.item :active="$activeTab === 'analytics'" wire:click="setActiveTab('analytics')">
            <x-slot:icon>
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M22.84 2.9982v17.9987c.0086.7916-.2747 1.5595-.7918 2.1453-.5765.5191-1.3282.7918-2.0999.7636-.7716.0282-1.5765-.2445-2.153-.7636-.5171-.5858-.8003-1.3537-.7918-2.1453V2.9982c-.0085-.7917.2747-1.5596.7918-2.1454C18.3818.3336 19.1335.0609 19.9051.0892c.7717-.0283 1.5234.2444 2.0999.7636.5171.5858.8004 1.3537.7918 2.1454h-.0128zM4.1596 16.9987v3.9996c.0085.7916-.2748 1.5596-.7918 2.1453-.5765.5192-1.3283.7918-2.0999.7636C.496 23.8354-.309 23.5627-.8855 23.0436c-.5171-.5857-.8004-1.3537-.7918-2.1453v-3.9996c-.0086-.7917.2747-1.5596.7918-2.1454.5765-.5191 1.3282-.7917 2.0999-.7635.7716-.0282 1.5234.2444 2.0999.7635.517.5858.8003 1.3537.7918 2.1454h.0455zm9.34-6.9984v10.9991c.0086.7916-.2747 1.5595-.7917 2.1453-.5765.5191-1.3283.7918-2.1.7636-.7716.0282-1.5233-.2445-2.0998-.7636-.5171-.5858-.8004-1.3537-.7918-2.1453V10.0003c-.0086-.7916.2747-1.5595.7918-2.1453.5765-.5192 1.3282-.7918 2.0998-.7636.7717-.0282 1.5235.2444 2.1.7636.517.5858.8003 1.3537.7917 2.1453z"/>
                </svg>
            </x-slot:icon>
            Google Analytics
        </x-admin.tabs.item>

        {{-- Tab: Facebook --}}
        <x-admin.tabs.item :active="$activeTab === 'facebook'" wire:click="setActiveTab('facebook')">
            <x-slot:icon>
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
            </x-slot:icon>
            Facebook
        </x-admin.tabs.item>
    </x-admin.tabs>

    {{-- Contenido de Tabs --}}
    <div class="space-y-6">
        {{-- Tab: Inteligencia Artificial --}}
        <div x-show="$wire.activeTab === 'ia'" x-cloak>
            <form wire:submit="guardarIA">
                {{ $this->iaForm }}

                <div class="mt-4 flex gap-3">
                    <x-filament::button type="submit">
                        Guardar Configuración
                    </x-filament::button>

                    <x-filament::button
                        type="button"
                        color="gray"
                        wire:click="probarConexionIA"
                    >
                        Probar Conexión
                    </x-filament::button>
                </div>
            </form>

            {{-- Información de ayuda IA --}}
            <x-filament::section class="mt-6" collapsible collapsed>
                <x-slot name="heading">
                    Cómo obtener tu API Key de OpenAI
                </x-slot>

                <div class="prose prose-sm dark:prose-invert max-w-none">
                    <ol>
                        <li>
                            <strong>Crear cuenta en OpenAI:</strong>
                            <ul>
                                <li>Ve a <a href="https://platform.openai.com" target="_blank" class="text-primary-600 hover:underline">platform.openai.com</a></li>
                                <li>Crea una cuenta o inicia sesión</li>
                            </ul>
                        </li>
                        <li>
                            <strong>Agregar créditos (si es necesario):</strong>
                            <ul>
                                <li>Ve a <strong>Settings → Billing</strong></li>
                                <li>Agrega un método de pago y créditos</li>
                                <li>GPT-4o Mini cuesta aproximadamente $0.15 por cada 1M tokens</li>
                            </ul>
                        </li>
                        <li>
                            <strong>Crear API Key:</strong>
                            <ul>
                                <li>Ve a <strong>API Keys</strong> en el menú lateral</li>
                                <li>Haz clic en <strong>"Create new secret key"</strong></li>
                                <li>Copia la clave (empieza con <code>sk-</code>)</li>
                                <li><strong>Importante:</strong> Solo podrás verla una vez</li>
                            </ul>
                        </li>
                    </ol>

                    <div class="mt-4 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <p class="text-sm text-blue-800 dark:text-blue-200">
                            <strong>Recomendación:</strong> Usa el modelo <strong>GPT-4o Mini</strong> para traducciones. Es rápido, económico y ofrece excelente calidad para este tipo de tareas.
                        </p>
                    </div>
                </div>
            </x-filament::section>
        </div>

        {{-- Tab: Analytics --}}
        <div x-show="$wire.activeTab === 'analytics'" x-cloak>
            <form wire:submit="guardarAnalytics">
                {{ $this->analyticsForm }}

                <div class="mt-4">
                    <x-filament::button type="submit">
                        Guardar Configuración
                    </x-filament::button>
                </div>
            </form>

            {{-- Información de ayuda Analytics --}}
            <x-filament::section class="mt-6" collapsible collapsed>
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
        </div>

        {{-- Tab: Facebook --}}
        <div x-show="$wire.activeTab === 'facebook'" x-cloak>
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
            <x-filament::section class="mt-6" collapsible collapsed>
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
    </div>
</x-filament-panels::page>
