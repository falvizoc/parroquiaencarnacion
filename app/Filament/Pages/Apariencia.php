<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class Apariencia extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-paint-brush';
    protected static ?string $navigationLabel = 'Apariencia';
    protected static ?string $title = 'Apariencia del Sitio';
    protected static ?string $navigationGroup = 'Configuración';
    protected static ?int $navigationSort = 90;
    protected static string $view = 'filament.pages.apariencia';

    public ?array $heroData = [];
    public ?array $adoracionData = [];
    public ?array $identidadData = [];

    // Tab activo
    public string $activeTab = 'identidad';

    // URLs de previsualización (actualizadas en tiempo real)
    public ?string $heroPreviewUrl = null;
    public ?string $adoracionPreviewUrl = null;
    public ?string $logotipoPreviewUrl = null;
    public ?string $faviconPreviewUrl = null;
    public string $adoracionPosicion = 'center';

    public function mount(): void
    {
        // Cargar datos del Hero
        $ctaPrincipal = Setting::obtener('hero_cta_principal', []);
        $ctaSecundario = Setting::obtener('hero_cta_secundario', []);

        $this->heroData = [
            'hero_imagen' => Setting::obtener('hero_imagen', ''),
            'hero_cta_principal_texto' => $ctaPrincipal['texto'] ?? '',
            'hero_cta_principal_url' => $ctaPrincipal['url'] ?? '',
            'hero_cta_secundario_texto' => $ctaSecundario['texto'] ?? '',
            'hero_cta_secundario_url' => $ctaSecundario['url'] ?? '',
            'hero_efectos_activos' => Setting::obtener('hero_efectos_activos', true),
        ];

        // Cargar datos de Adoración
        $this->adoracionData = [
            'adoracion_imagen' => Setting::obtener('adoracion_imagen', ''),
            'adoracion_posicion' => Setting::obtener('adoracion_posicion', 'center'),
            'adoracion_efectos_activos' => Setting::obtener('adoracion_efectos_activos', true),
        ];

        // Cargar datos de Identidad
        $this->identidadData = [
            'logotipo' => Setting::obtener('logotipo', ''),
            'favicon' => Setting::obtener('favicon', ''),
            'nombre_parroquia' => Setting::obtener('nombre_parroquia', 'Parroquia Nuestra Señora de la Encarnación'),
            'slogan' => Setting::obtener('slogan', 'Comunidad de fe, esperanza y caridad'),
            'ubicacion' => Setting::obtener('ubicacion', 'Tampico, Tamaulipas, México'),
        ];

        $this->heroForm->fill($this->heroData);
        $this->adoracionForm->fill($this->adoracionData);
        $this->identidadForm->fill($this->identidadData);

        // Inicializar URLs de previsualización
        $this->actualizarPreviews();
    }

    /**
     * Actualiza las URLs de previsualización basadas en los datos del formulario
     */
    public function actualizarPreviews(): void
    {
        // Hero preview
        $heroImagen = $this->heroData['hero_imagen'] ?? null;
        $this->heroPreviewUrl = $this->obtenerUrlImagen($heroImagen);

        // Adoración preview
        $adoracionImagen = $this->adoracionData['adoracion_imagen'] ?? null;
        $this->adoracionPreviewUrl = $this->obtenerUrlImagen($adoracionImagen);
        $this->adoracionPosicion = $this->adoracionData['adoracion_posicion'] ?? 'center';

        // Identidad preview
        $logotipo = $this->identidadData['logotipo'] ?? null;
        $this->logotipoPreviewUrl = $this->obtenerUrlImagen($logotipo);
        $favicon = $this->identidadData['favicon'] ?? null;
        $this->faviconPreviewUrl = $this->obtenerUrlImagen($favicon);
    }

    /**
     * Obtiene la URL de una imagen, manejando archivos temporales y permanentes
     */
    protected function obtenerUrlImagen($imagen): ?string
    {
        if (empty($imagen)) {
            return null;
        }

        // Si es un array (Filament FileUpload devuelve array)
        if (is_array($imagen)) {
            $imagen = reset($imagen); // Obtener primer elemento
            if (empty($imagen)) {
                return null;
            }
        }

        // Si es un string (path guardado en BD)
        if (is_string($imagen)) {
            return \Illuminate\Support\Facades\Storage::disk('public')->url($imagen);
        }

        // Si es un archivo temporal de Livewire (TemporaryUploadedFile)
        if ($imagen instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            return $imagen->temporaryUrl();
        }

        return null;
    }

    /**
     * Listener para cuando cambia la imagen del Hero
     */
    public function updatedHeroData(): void
    {
        $this->actualizarPreviews();
    }

    /**
     * Listener para cuando cambia la imagen de Adoración
     */
    public function updatedAdoracionData(): void
    {
        $this->actualizarPreviews();
    }

    /**
     * Listener para cuando cambia el logotipo
     */
    public function updatedIdentidadData(): void
    {
        $this->actualizarPreviews();
    }

    protected function getForms(): array
    {
        return ['heroForm', 'adoracionForm', 'identidadForm'];
    }

    public function heroForm(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Sección Hero (Página de Inicio)')
                    ->description('Configura la imagen de fondo y botones de llamada a la acción del hero principal.')
                    ->icon('heroicon-o-photo')
                    ->schema([
                        Forms\Components\FileUpload::make('hero_imagen')
                            ->label('Imagen de Fondo')
                            ->image()
                            ->directory('heroes')
                            ->disk('public')
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('1920')
                            ->imageResizeTargetHeight('1080')
                            ->helperText('Recomendado: 1920x1080px. Si no se sube imagen, se usará el gradiente predeterminado.')
                            ->live()
                            ->afterStateUpdated(fn () => $this->actualizarPreviews())
                            ->columnSpanFull(),

                        Forms\Components\Toggle::make('hero_efectos_activos')
                            ->label('Efectos visuales activos')
                            ->helperText('Parallax, fade en scroll y animaciones de luz')
                            ->default(true),

                        Forms\Components\Fieldset::make('Botón Principal')
                            ->schema([
                                Forms\Components\TextInput::make('hero_cta_principal_texto')
                                    ->label('Texto')
                                    ->placeholder('Ver Horarios')
                                    ->maxLength(50),
                                Forms\Components\TextInput::make('hero_cta_principal_url')
                                    ->label('URL')
                                    ->placeholder('/es/horarios')
                                    ->maxLength(255),
                            ])->columns(2),

                        Forms\Components\Fieldset::make('Botón Secundario')
                            ->schema([
                                Forms\Components\TextInput::make('hero_cta_secundario_texto')
                                    ->label('Texto')
                                    ->placeholder('Contacto')
                                    ->maxLength(50),
                                Forms\Components\TextInput::make('hero_cta_secundario_url')
                                    ->label('URL')
                                    ->placeholder('/es/contacto')
                                    ->maxLength(255),
                            ])->columns(2),
                    ]),
            ])
            ->statePath('heroData');
    }

    public function identidadForm(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Logotipo de la Parroquia')
                    ->description('Sube el logotipo oficial de la parroquia para mostrar en el sitio web.')
                    ->icon('heroicon-o-building-library')
                    ->schema([
                        Forms\Components\FileUpload::make('logotipo')
                            ->label('Logotipo Principal')
                            ->image()
                            ->directory('identidad')
                            ->disk('public')
                            ->imageResizeMode('contain')
                            ->imageResizeTargetWidth('400')
                            ->imageResizeTargetHeight('400')
                            ->acceptedFileTypes(['image/png', 'image/svg+xml', 'image/webp'])
                            ->helperText('Formato: PNG, SVG o WebP con fondo transparente. Resolución recomendada: 200x200 a 400x400 px. Tamaño máximo: 1MB.')
                            ->maxSize(1024)
                            ->live()
                            ->afterStateUpdated(fn () => $this->actualizarPreviews()),

                        Forms\Components\FileUpload::make('favicon')
                            ->label('Favicon')
                            ->image()
                            ->directory('identidad')
                            ->disk('public')
                            ->imageResizeMode('contain')
                            ->imageResizeTargetWidth('64')
                            ->imageResizeTargetHeight('64')
                            ->acceptedFileTypes(['image/png', 'image/x-icon', 'image/ico'])
                            ->helperText('Icono para la pestaña del navegador. Formato: PNG o ICO. Resolución: 32x32 o 64x64 px.')
                            ->maxSize(256)
                            ->live()
                            ->afterStateUpdated(fn () => $this->actualizarPreviews()),
                    ]),

                Forms\Components\Section::make('Información de la Parroquia')
                    ->description('Esta información se muestra en el encabezado y pie de página.')
                    ->icon('heroicon-o-identification')
                    ->schema([
                        Forms\Components\TextInput::make('nombre_parroquia')
                            ->label('Nombre de la Parroquia')
                            ->placeholder('Parroquia Nuestra Señora de la Encarnación')
                            ->maxLength(100)
                            ->helperText('El nombre completo se usará en títulos y meta tags.'),

                        Forms\Components\TextInput::make('slogan')
                            ->label('Slogan / Lema')
                            ->placeholder('Comunidad de fe, esperanza y caridad')
                            ->maxLength(150)
                            ->helperText('Frase que aparece debajo del nombre en el footer.'),

                        Forms\Components\TextInput::make('ubicacion')
                            ->label('Ubicación')
                            ->placeholder('Tampico, Tamaulipas, México')
                            ->maxLength(100)
                            ->helperText('Se muestra debajo del nombre en el header.'),
                    ]),
            ])
            ->statePath('identidadData');
    }

    public function adoracionForm(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Sección Adoración (Página de Inicio)')
                    ->description('Configura la imagen de fondo de la sección de Adoración Perpetua.')
                    ->icon('heroicon-o-sparkles')
                    ->schema([
                        Forms\Components\FileUpload::make('adoracion_imagen')
                            ->label('Imagen de Fondo')
                            ->image()
                            ->directory('adoracion')
                            ->disk('public')
                            ->imageResizeMode('cover')
                            ->imageResizeTargetWidth('1920')
                            ->imageResizeTargetHeight('1080')
                            ->helperText('Recomendado: imagen horizontal de alta resolución.')
                            ->live()
                            ->afterStateUpdated(fn () => $this->actualizarPreviews())
                            ->columnSpanFull(),

                        Forms\Components\Select::make('adoracion_posicion')
                            ->label('Posición de la imagen')
                            ->options([
                                'top' => '↑ Arriba - Muestra la parte superior',
                                'center' => '⬤ Centro - Muestra el centro (predeterminado)',
                                'bottom' => '↓ Abajo - Muestra la parte inferior',
                            ])
                            ->default('center')
                            ->live()
                            ->afterStateUpdated(fn () => $this->actualizarPreviews())
                            ->helperText('Selecciona qué parte de la imagen se mostrará en la sección.'),

                        Forms\Components\Toggle::make('adoracion_efectos_activos')
                            ->label('Efectos visuales activos')
                            ->helperText('Parallax suave y animaciones de luz dorada')
                            ->default(true),
                    ]),
            ])
            ->statePath('adoracionData');
    }

    public function guardarHero(): void
    {
        $data = $this->heroForm->getState();

        // Guardar imagen
        Setting::establecer('hero_imagen', $data['hero_imagen'] ?? '', [
            'grupo' => 'apariencia',
        ]);

        // Guardar CTA principal como JSON
        Setting::establecer('hero_cta_principal', [
            'texto' => $data['hero_cta_principal_texto'] ?? '',
            'url' => $data['hero_cta_principal_url'] ?? '',
        ], [
            'grupo' => 'apariencia',
            'tipo' => 'json',
        ]);

        // Guardar CTA secundario como JSON
        Setting::establecer('hero_cta_secundario', [
            'texto' => $data['hero_cta_secundario_texto'] ?? '',
            'url' => $data['hero_cta_secundario_url'] ?? '',
        ], [
            'grupo' => 'apariencia',
            'tipo' => 'json',
        ]);

        // Guardar toggle de efectos
        Setting::establecer('hero_efectos_activos', $data['hero_efectos_activos'] ?? true, [
            'grupo' => 'apariencia',
            'tipo' => 'boolean',
        ]);

        Notification::make()
            ->title('Hero actualizado')
            ->body('La configuración del Hero se ha guardado correctamente.')
            ->success()
            ->send();
    }

    public function guardarAdoracion(): void
    {
        $data = $this->adoracionForm->getState();

        Setting::establecer('adoracion_imagen', $data['adoracion_imagen'] ?? '', [
            'grupo' => 'apariencia',
        ]);

        Setting::establecer('adoracion_posicion', $data['adoracion_posicion'] ?? 'center', [
            'grupo' => 'apariencia',
        ]);

        Setting::establecer('adoracion_efectos_activos', $data['adoracion_efectos_activos'] ?? true, [
            'grupo' => 'apariencia',
            'tipo' => 'boolean',
        ]);

        Notification::make()
            ->title('Adoración actualizada')
            ->body('La configuración de la sección de Adoración se ha guardado correctamente.')
            ->success()
            ->send();
    }

    public function guardarIdentidad(): void
    {
        $data = $this->identidadForm->getState();

        Setting::establecer('logotipo', $data['logotipo'] ?? '', [
            'grupo' => 'identidad',
        ]);

        Setting::establecer('favicon', $data['favicon'] ?? '', [
            'grupo' => 'identidad',
        ]);

        Setting::establecer('nombre_parroquia', $data['nombre_parroquia'] ?? '', [
            'grupo' => 'identidad',
        ]);

        Setting::establecer('slogan', $data['slogan'] ?? '', [
            'grupo' => 'identidad',
        ]);

        Setting::establecer('ubicacion', $data['ubicacion'] ?? '', [
            'grupo' => 'identidad',
        ]);

        Notification::make()
            ->title('Identidad actualizada')
            ->body('El logotipo e información de la parroquia se han guardado correctamente.')
            ->success()
            ->send();
    }
}
