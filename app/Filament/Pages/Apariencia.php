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
            'adoracion_efectos_activos' => Setting::obtener('adoracion_efectos_activos', true),
        ];

        $this->heroForm->fill($this->heroData);
        $this->adoracionForm->fill($this->adoracionData);
    }

    protected function getForms(): array
    {
        return ['heroForm', 'adoracionForm'];
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
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('1920')
                            ->imageResizeTargetHeight('800')
                            ->helperText('Recomendado: 1920x800px. Si no se sube imagen, se usará el gradiente dorado.')
                            ->columnSpanFull(),

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
}
