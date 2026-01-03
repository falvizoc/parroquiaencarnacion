<?php

namespace App\Filament\Traits;

/**
 * Trait para persistir la selección de idioma en sesión.
 *
 * Sobrescribe getDefaultTranslatableLocale() para que Filament use
 * el locale guardado en sesión al cargar los datos del formulario.
 */
trait PersistentTranslatable
{
    /**
     * Inicializa el locale desde la sesión al montar el componente.
     */
    public function mountPersistentTranslatable(): void
    {
        $savedLocale = session('filament_locale', 'es');

        if (in_array($savedLocale, ['es', 'en'])) {
            $this->activeLocale = $savedLocale;
        }
    }

    /**
     * Sobrescribe el método de Filament para retornar el locale de sesión.
     * Esto asegura que fillForm() use el locale correcto al cargar datos.
     */
    protected function getDefaultTranslatableLocale(): string
    {
        $savedLocale = session('filament_locale', 'es');

        if (in_array($savedLocale, ['es', 'en'])) {
            return $savedLocale;
        }

        // Fallback al método padre si existe
        if (method_exists(get_parent_class($this), 'getDefaultTranslatableLocale')) {
            return parent::getDefaultTranslatableLocale();
        }

        return 'es';
    }

    /**
     * Guarda el locale en la sesión cada vez que el componente se deshidrata.
     * Esto captura cualquier cambio en activeLocale sin colisionar con Filament.
     */
    public function dehydratePersistentTranslatable(): void
    {
        if (property_exists($this, 'activeLocale') && $this->activeLocale) {
            session(['filament_locale' => $this->activeLocale]);
        }
    }
}
