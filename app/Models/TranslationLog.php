<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class TranslationLog extends Model
{
    protected $fillable = [
        'translatable_type',
        'translatable_id',
        'field',
        'source_locale',
        'target_locale',
        'source_text',
        'translated_text',
        'status',
        'error_message',
        'tokens_used',
        'cost_usd',
    ];

    protected function casts(): array
    {
        return [
            'tokens_used' => 'integer',
            'cost_usd' => 'decimal:6',
        ];
    }

    /**
     * Estados posibles de traducción.
     */
    public const ESTADOS = [
        'pending' => 'Pendiente',
        'processing' => 'Procesando',
        'completed' => 'Completado',
        'failed' => 'Fallido',
    ];

    // Relaciones

    /**
     * Modelo traducible (polimórfico).
     */
    public function translatable(): MorphTo
    {
        return $this->morphTo();
    }

    // Scopes

    /**
     * Logs pendientes.
     */
    public function scopePendientes(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    /**
     * Logs completados.
     */
    public function scopeCompletados(Builder $query): Builder
    {
        return $query->where('status', 'completed');
    }

    /**
     * Logs fallidos.
     */
    public function scopeFallidos(Builder $query): Builder
    {
        return $query->where('status', 'failed');
    }

    /**
     * Logs de un modelo específico.
     */
    public function scopeParaModelo(Builder $query, string $tipo, int $id): Builder
    {
        return $query->where('translatable_type', $tipo)
            ->where('translatable_id', $id);
    }

    // Accessors

    /**
     * Nombre legible del estado.
     */
    public function getNombreEstadoAttribute(): string
    {
        return self::ESTADOS[$this->status] ?? $this->status;
    }

    /**
     * Nombre corto del modelo.
     */
    public function getNombreModeloAttribute(): string
    {
        return class_basename($this->translatable_type);
    }

    // Métodos

    /**
     * Marcar como procesando.
     */
    public function marcarProcesando(): void
    {
        $this->update(['status' => 'processing']);
    }

    /**
     * Marcar como completado.
     */
    public function marcarCompletado(string $textoTraducido, ?int $tokens = null, ?float $costo = null): void
    {
        $this->update([
            'status' => 'completed',
            'translated_text' => $textoTraducido,
            'tokens_used' => $tokens,
            'cost_usd' => $costo,
        ]);
    }

    /**
     * Marcar como fallido.
     */
    public function marcarFallido(string $mensaje): void
    {
        $this->update([
            'status' => 'failed',
            'error_message' => $mensaje,
        ]);
    }

    /**
     * Obtener estadísticas de traducciones.
     */
    public static function obtenerEstadisticas(): array
    {
        return [
            'total' => self::count(),
            'pendientes' => self::pendientes()->count(),
            'completados' => self::completados()->count(),
            'fallidos' => self::fallidos()->count(),
            'costo_total' => self::completados()->sum('cost_usd'),
            'tokens_total' => self::completados()->sum('tokens_used'),
        ];
    }
}
