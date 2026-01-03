<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use App\Services\FacebookService;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class Integraciones extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-link';

    protected static ?string $navigationLabel = 'Integraciones';

    protected static ?string $title = 'Integraciones';

    protected static ?string $navigationGroup = 'Configuración';

    protected static ?int $navigationSort = 100;

    protected static string $view = 'filament.pages.integraciones';

    public ?array $facebookData = [];
    public ?array $analyticsData = [];
    public ?array $openaiData = [];

    public function mount(): void
    {
        $this->facebookData = [
            'facebook_activo' => Setting::obtener('facebook_activo', false),
            'facebook_app_id' => Setting::obtener('facebook_app_id', ''),
            'facebook_app_secret' => Setting::obtener('facebook_app_secret', ''),
            'facebook_page_id' => Setting::obtener('facebook_page_id', ''),
            'facebook_access_token' => Setting::obtener('facebook_access_token', ''),
        ];

        $this->analyticsData = [
            'analytics_activo' => Setting::obtener('analytics_activo', false),
            'ga4_measurement_id' => Setting::obtener('ga4_measurement_id', ''),
            'search_console_verificacion' => Setting::obtener('search_console_verificacion', ''),
        ];

        $this->openaiData = [
            'openai_activo' => Setting::obtener('openai_activo', false),
            'openai_api_key' => Setting::obtener('openai_api_key', ''),
            'openai_modelo' => Setting::obtener('openai_modelo', 'gpt-4o-mini'),
        ];

        $this->facebookForm->fill($this->facebookData);
        $this->analyticsForm->fill($this->analyticsData);
        $this->openaiForm->fill($this->openaiData);
    }

    protected function getForms(): array
    {
        return [
            'facebookForm',
            'analyticsForm',
            'openaiForm',
        ];
    }

    public function facebookForm(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Facebook')
                    ->description('Configura la integración con Facebook para importar publicaciones y sincronizar contenido.')
                    ->icon('heroicon-o-globe-alt')
                    ->schema([
                        Forms\Components\Toggle::make('facebook_activo')
                            ->label('Integración activa')
                            ->helperText('Activa o desactiva la integración con Facebook')
                            ->live(),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('facebook_app_id')
                                    ->label('App ID')
                                    ->placeholder('Tu Facebook App ID')
                                    ->helperText('Obtenlo en developers.facebook.com')
                                    ->disabled(fn (Forms\Get $get) => !$get('facebook_activo')),

                                Forms\Components\TextInput::make('facebook_app_secret')
                                    ->label('App Secret')
                                    ->password()
                                    ->revealable()
                                    ->placeholder('Tu Facebook App Secret')
                                    ->helperText('Mantén este valor seguro')
                                    ->disabled(fn (Forms\Get $get) => !$get('facebook_activo')),

                                Forms\Components\TextInput::make('facebook_page_id')
                                    ->label('Page ID')
                                    ->placeholder('ID de tu página de Facebook')
                                    ->helperText('El ID numérico de la página de la parroquia')
                                    ->disabled(fn (Forms\Get $get) => !$get('facebook_activo')),

                                Forms\Components\Textarea::make('facebook_access_token')
                                    ->label('Access Token')
                                    ->placeholder('Token de acceso de larga duración')
                                    ->helperText('Token con permisos pages_read_engagement')
                                    ->rows(2)
                                    ->disabled(fn (Forms\Get $get) => !$get('facebook_activo')),
                            ]),

                        Forms\Components\Placeholder::make('facebook_estado')
                            ->label('Estado de la conexión')
                            ->content(function () {
                                $activo = Setting::obtener('facebook_activo', false);
                                $appId = Setting::obtener('facebook_app_id');
                                $token = Setting::obtener('facebook_access_token');

                                if (!$activo) {
                                    return '⚪ Integración desactivada';
                                }

                                if (empty($appId) || empty($token)) {
                                    return '🟡 Configuración incompleta';
                                }

                                return '🟢 Configurado - Usa "Probar Conexión" para verificar';
                            }),
                    ]),
            ])
            ->statePath('facebookData');
    }

    public function analyticsForm(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Google Analytics & Search Console')
                    ->description('Configura el seguimiento de analíticas y verificación de Search Console.')
                    ->icon('heroicon-o-chart-bar')
                    ->schema([
                        Forms\Components\Toggle::make('analytics_activo')
                            ->label('Analytics activo')
                            ->helperText('Activa o desactiva el tracking de Google Analytics')
                            ->live(),

                        Forms\Components\TextInput::make('ga4_measurement_id')
                            ->label('GA4 Measurement ID')
                            ->placeholder('G-XXXXXXXXXX')
                            ->helperText('ID de medición de Google Analytics 4 (formato: G-XXXXXXXXXX)')
                            ->disabled(fn (Forms\Get $get) => !$get('analytics_activo'))
                            ->regex('/^G-[A-Z0-9]+$/i'),

                        Forms\Components\TextInput::make('search_console_verificacion')
                            ->label('Verificación Search Console')
                            ->placeholder('google-site-verification=XXXXX')
                            ->helperText('Contenido del meta tag de verificación de Google Search Console')
                            ->columnSpanFull(),

                        Forms\Components\Placeholder::make('analytics_estado')
                            ->label('Estado')
                            ->content(function () {
                                $activo = Setting::obtener('analytics_activo', false);
                                $gaId = Setting::obtener('ga4_measurement_id');

                                if (!$activo) {
                                    return '⚪ Analytics desactivado';
                                }

                                if (empty($gaId)) {
                                    return '🟡 Falta configurar Measurement ID';
                                }

                                return '🟢 Analytics configurado y activo';
                            }),
                    ]),
            ])
            ->statePath('analyticsData');
    }

    public function openaiForm(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('OpenAI - Traducciones con IA')
                    ->description('Configura la API de OpenAI para traducción automática de contenido.')
                    ->icon('heroicon-o-language')
                    ->schema([
                        Forms\Components\Toggle::make('openai_activo')
                            ->label('Integración activa')
                            ->helperText('Activa o desactiva las traducciones automáticas con IA')
                            ->live(),

                        Forms\Components\TextInput::make('openai_api_key')
                            ->label('API Key')
                            ->password()
                            ->revealable()
                            ->placeholder('sk-...')
                            ->helperText('Tu clave de API de OpenAI. Consíguela en platform.openai.com')
                            ->disabled(fn (Forms\Get $get) => !$get('openai_activo')),

                        Forms\Components\Select::make('openai_modelo')
                            ->label('Modelo de IA')
                            ->options([
                                'gpt-4o-mini' => 'GPT-4o Mini (Recomendado - Económico y rápido)',
                                'gpt-4o' => 'GPT-4o (Mayor calidad, más costoso)',
                                'gpt-3.5-turbo' => 'GPT-3.5 Turbo (Más económico, menor calidad)',
                            ])
                            ->default('gpt-4o-mini')
                            ->helperText('El modelo a usar para las traducciones')
                            ->disabled(fn (Forms\Get $get) => !$get('openai_activo')),

                        Forms\Components\Placeholder::make('openai_estado')
                            ->label('Estado de la conexión')
                            ->content(function () {
                                $activo = Setting::obtener('openai_activo', false);
                                $apiKey = Setting::obtener('openai_api_key');

                                if (!$activo) {
                                    return '⚪ Integración desactivada';
                                }

                                if (empty($apiKey)) {
                                    return '🟡 Falta configurar API Key';
                                }

                                return '🟢 Configurado - Usa "Probar Conexión" para verificar';
                            }),
                    ]),
            ])
            ->statePath('openaiData');
    }

    public function guardarAnalytics(): void
    {
        $data = $this->analyticsForm->getState();

        Setting::establecer('analytics_activo', $data['analytics_activo'], [
            'grupo' => 'analytics',
            'tipo' => 'boolean',
        ]);

        Setting::establecer('ga4_measurement_id', $data['ga4_measurement_id'], [
            'grupo' => 'analytics',
        ]);

        Setting::establecer('search_console_verificacion', $data['search_console_verificacion'], [
            'grupo' => 'analytics',
        ]);

        Notification::make()
            ->title('Configuración guardada')
            ->body('La configuración de Analytics se ha guardado correctamente.')
            ->success()
            ->send();
    }

    public function guardarFacebook(): void
    {
        $data = $this->facebookForm->getState();

        Setting::establecer('facebook_activo', $data['facebook_activo'], [
            'grupo' => 'facebook',
            'tipo' => 'boolean',
        ]);

        Setting::establecer('facebook_app_id', $data['facebook_app_id'], [
            'grupo' => 'facebook',
            'es_sensible' => true,
        ]);

        Setting::establecer('facebook_app_secret', $data['facebook_app_secret'], [
            'grupo' => 'facebook',
            'es_sensible' => true,
        ]);

        Setting::establecer('facebook_page_id', $data['facebook_page_id'], [
            'grupo' => 'facebook',
        ]);

        Setting::establecer('facebook_access_token', $data['facebook_access_token'], [
            'grupo' => 'facebook',
            'es_sensible' => true,
        ]);

        Notification::make()
            ->title('Configuración guardada')
            ->body('La configuración de Facebook se ha guardado correctamente.')
            ->success()
            ->send();
    }

    public function probarConexionFacebook(): void
    {
        $activo = Setting::obtener('facebook_activo', false);

        if (!$activo) {
            Notification::make()
                ->title('Integración desactivada')
                ->body('Activa la integración antes de probar la conexión.')
                ->warning()
                ->send();
            return;
        }

        $facebookService = app(FacebookService::class);

        if (!$facebookService->estaConfigurado()) {
            Notification::make()
                ->title('Configuración incompleta')
                ->body('Completa todos los campos requeridos antes de probar.')
                ->warning()
                ->send();
            return;
        }

        $resultado = $facebookService->probarConexion();

        if ($resultado['exito']) {
            Notification::make()
                ->title('Conexión exitosa')
                ->body("Página: {$resultado['nombre_pagina']}")
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title('Error de conexión')
                ->body($resultado['error'])
                ->danger()
                ->send();
        }
    }

    public function guardarOpenai(): void
    {
        $data = $this->openaiForm->getState();

        Setting::establecer('openai_activo', $data['openai_activo'], [
            'grupo' => 'openai',
            'tipo' => 'boolean',
        ]);

        Setting::establecer('openai_api_key', $data['openai_api_key'], [
            'grupo' => 'openai',
            'es_sensible' => true,
        ]);

        Setting::establecer('openai_modelo', $data['openai_modelo'], [
            'grupo' => 'openai',
        ]);

        Notification::make()
            ->title('Configuración guardada')
            ->body('La configuración de OpenAI se ha guardado correctamente.')
            ->success()
            ->send();
    }

    public function probarConexionOpenai(): void
    {
        $activo = Setting::obtener('openai_activo', false);

        if (!$activo) {
            Notification::make()
                ->title('Integración desactivada')
                ->body('Activa la integración antes de probar la conexión.')
                ->warning()
                ->send();
            return;
        }

        $apiKey = Setting::obtener('openai_api_key');

        if (empty($apiKey)) {
            Notification::make()
                ->title('Configuración incompleta')
                ->body('Ingresa tu API Key antes de probar.')
                ->warning()
                ->send();
            return;
        }

        try {
            $modelo = Setting::obtener('openai_modelo', 'gpt-4o-mini');

            // Crear cliente temporal con la API Key configurada
            $client = \OpenAI::factory()
                ->withApiKey($apiKey)
                ->make();

            $response = $client->chat()->create([
                'model' => $modelo,
                'messages' => [
                    ['role' => 'user', 'content' => 'Responde solo con "OK" sin nada más.'],
                ],
                'max_tokens' => 5,
            ]);

            $respuesta = $response->choices[0]->message->content ?? '';

            Notification::make()
                ->title('Conexión exitosa')
                ->body("OpenAI respondió correctamente usando el modelo {$modelo}.")
                ->success()
                ->send();
        } catch (\Exception $e) {
            $mensaje = $e->getMessage();

            // Simplificar mensajes de error comunes
            if (str_contains($mensaje, 'Incorrect API key')) {
                $mensaje = 'API Key inválida. Verifica que sea correcta.';
            } elseif (str_contains($mensaje, 'exceeded your current quota')) {
                $mensaje = 'Sin créditos disponibles. Recarga tu cuenta en OpenAI.';
            } elseif (str_contains($mensaje, 'model')) {
                $mensaje = 'Modelo no disponible. Prueba con otro modelo.';
            }

            Notification::make()
                ->title('Error de conexión')
                ->body($mensaje)
                ->danger()
                ->send();
        }
    }
}
