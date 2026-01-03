<?php

namespace App\Traits;

use App\Jobs\TranslateContentJob;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Translatable\HasTranslations;

trait HasAiTranslation
{
    use HasTranslations;

    /**
     * Campos que fueron modificados antes del guardado.
     */
    protected array $camposModificadosParaTraduccion = [];

    /**
     * Hook que se ejecuta al iniciar el trait.
     */
    protected static function bootHasAiTranslation(): void
    {
        // Antes de guardar, capturar qué campos traducibles cambiaron
        static::saving(function ($model) {
            $model->capturarCambiosTraducibles();
        });

        // Después de guardar, disparar traducción si hay cambios
        static::saved(function ($model) {
            if ($model->debeTraducir()) {
                TranslateContentJob::dispatch($model, $model->camposModificadosParaTraduccion);
            }
        });
    }

    /**
     * Scope para filtrar solo registros con traducción en el idioma actual.
     *
     * Usa el primer campo traducible (generalmente titulo o nombre) como indicador.
     */
    public function scopeConTraduccion(Builder $query): Builder
    {
        $locale = app()->getLocale();

        // Si es español, no filtrar (es el idioma base)
        if ($locale === 'es') {
            return $query;
        }

        // Obtener el primer campo traducible como indicador
        $campoIndicador = $this->getTranslatableAttributes()[0] ?? null;

        if (!$campoIndicador) {
            return $query;
        }

        // Filtrar registros que tengan traducción en el campo indicador
        return $query->whereRaw("JSON_EXTRACT({$campoIndicador}, '$.{$locale}') IS NOT NULL")
                     ->whereRaw("JSON_EXTRACT({$campoIndicador}, '$.{$locale}') != ''")
                     ->whereRaw("JSON_EXTRACT({$campoIndicador}, '$.{$locale}') != '\"\"'");
    }

    /**
     * Captura los campos traducibles que fueron modificados.
     */
    protected function capturarCambiosTraducibles(): void
    {
        $this->camposModificadosParaTraduccion = [];

        foreach ($this->getTranslatableAttributes() as $campo) {
            if ($this->isDirty($campo)) {
                $this->camposModificadosParaTraduccion[] = $campo;
            }
        }
    }

    /**
     * Determina si el modelo necesita traducción.
     */
    public function debeTraducir(): bool
    {
        // No traducir si está marcado como editado manualmente
        if ($this->translation_manually_edited ?? false) {
            return false;
        }

        // Solo traducir si hay campos traducibles modificados
        return count($this->camposModificadosParaTraduccion) > 0;
    }

    /**
     * Obtiene el contenido traducido con fallback al español.
     */
    public function obtenerTraducido(string $atributo): ?string
    {
        $locale = app()->getLocale();
        $valor = $this->getTranslation($atributo, $locale);

        // Fallback a español si no hay traducción
        if (empty($valor) && $locale !== 'es') {
            $valor = $this->getTranslation($atributo, 'es');
        }

        return $valor;
    }

    /**
     * Indica si tiene traducción completa al inglés.
     */
    public function tieneTraduccionIngles(): bool
    {
        foreach ($this->getTranslatableAttributes() as $campo) {
            $traduccion = $this->getTranslation($campo, 'en');
            if (empty($traduccion)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Indica si la traducción fue editada manualmente.
     */
    public function esTraduccionEditadaManualmente(): bool
    {
        return $this->translation_manually_edited ?? false;
    }

    /**
     * Obtiene el porcentaje de campos traducidos.
     */
    public function porcentajeTraduccion(): int
    {
        $campos = $this->getTranslatableAttributes();
        $traducidos = 0;

        foreach ($campos as $campo) {
            if (!empty($this->getTranslation($campo, 'en'))) {
                $traducidos++;
            }
        }

        return count($campos) > 0 ? (int) round(($traducidos / count($campos)) * 100) : 0;
    }

    /**
     * Marca el registro para evitar sobrescribir traducciones manuales.
     */
    public function marcarTraduccionManual(): void
    {
        $this->translation_manually_edited = true;
        $this->saveQuietly();
    }

    /**
     * Permite que las traducciones sean regeneradas por IA.
     */
    public function permitirRegeneracionTraduccion(): void
    {
        $this->translation_manually_edited = false;
        $this->saveQuietly();
    }
}
