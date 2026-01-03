<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;

class Setting extends Model
{
    protected $fillable = [
        'clave',
        'valor',
        'grupo',
        'tipo',
        'es_sensible',
    ];

    protected $casts = [
        'es_sensible' => 'boolean',
    ];

    /**
     * Grupos de configuración disponibles.
     */
    public const GRUPOS = [
        'facebook' => 'Facebook',
        'google' => 'Google',
        'email' => 'Email',
        'general' => 'General',
    ];

    /**
     * Tipos de datos.
     */
    public const TIPOS = [
        'string' => 'Texto',
        'boolean' => 'Sí/No',
        'integer' => 'Número',
        'json' => 'JSON',
    ];

    /**
     * Obtener valor, desencriptando si es sensible.
     */
    public function getValorDesencriptadoAttribute(): ?string
    {
        if ($this->es_sensible && $this->valor) {
            try {
                return Crypt::decryptString($this->valor);
            } catch (\Exception $e) {
                return null;
            }
        }

        return $this->valor;
    }

    /**
     * Establecer valor, encriptando si es sensible.
     */
    public function setValorAttribute($value): void
    {
        if ($this->es_sensible && $value) {
            $this->attributes['valor'] = Crypt::encryptString($value);
        } else {
            $this->attributes['valor'] = $value;
        }
    }

    /**
     * Obtener una configuración por clave.
     *
     * Nota: El default no se cachea para permitir que las traducciones
     * se evalúen correctamente según el idioma activo.
     */
    public static function obtener(string $clave, mixed $default = null): mixed
    {
        $cacheKey = "setting_{$clave}";

        // Intentar obtener del cache (solo valores reales, no defaults)
        $cached = Cache::get($cacheKey);
        if ($cached !== null) {
            return $cached;
        }

        // Buscar en la base de datos
        $setting = static::where('clave', $clave)->first();

        if (!$setting) {
            // Retornar default sin cachear (permite traducciones dinámicas)
            return $default;
        }

        $valor = $setting->valor_desencriptado;

        $resultado = match ($setting->tipo) {
            'boolean' => filter_var($valor, FILTER_VALIDATE_BOOLEAN),
            'integer' => (int) $valor,
            'json' => json_decode($valor, true),
            default => $valor,
        };

        // Cachear solo valores reales de la BD
        Cache::put($cacheKey, $resultado, 3600);

        return $resultado;
    }

    /**
     * Establecer una configuración.
     */
    public static function establecer(string $clave, mixed $valor, array $opciones = []): static
    {
        $setting = static::firstOrNew(['clave' => $clave]);

        $setting->grupo = $opciones['grupo'] ?? $setting->grupo ?? 'general';
        $setting->tipo = $opciones['tipo'] ?? $setting->tipo ?? 'string';
        $setting->es_sensible = $opciones['es_sensible'] ?? $setting->es_sensible ?? false;

        // Si es sensible, necesitamos forzar la encriptación
        if ($setting->es_sensible && $valor) {
            $setting->attributes['valor'] = Crypt::encryptString((string) $valor);
        } else {
            $setting->attributes['valor'] = is_array($valor) ? json_encode($valor) : (string) $valor;
        }

        $setting->save();

        // Limpiar caché
        Cache::forget("setting_{$clave}");

        return $setting;
    }

    /**
     * Obtener todas las configuraciones de un grupo.
     */
    public static function obtenerGrupo(string $grupo): array
    {
        $settings = static::where('grupo', $grupo)->get();

        $resultado = [];
        foreach ($settings as $setting) {
            $resultado[$setting->clave] = $setting->valor_desencriptado;
        }

        return $resultado;
    }

    /**
     * Limpiar caché de configuraciones.
     */
    public static function limpiarCache(?string $clave = null): void
    {
        if ($clave) {
            Cache::forget("setting_{$clave}");
        } else {
            // Limpiar todas las configuraciones en caché
            $claves = static::pluck('clave');
            foreach ($claves as $c) {
                Cache::forget("setting_{$c}");
            }
        }
    }
}
