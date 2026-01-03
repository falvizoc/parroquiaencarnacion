<?php

namespace App\Filament\Traits;

/**
 * Trait para persistir la selección de idioma en sesión.
 *
 * Usa hooks de Livewire que no colisionan con Filament\Translatable.
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
