<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailLog extends Model
{
    protected $fillable = [
        'email_campaign_id',
        'faithful_member_id',
        'email',
        'estado',
        'error',
        'enviado_at',
    ];

    protected function casts(): array
    {
        return [
            'enviado_at' => 'datetime',
        ];
    }

    /**
     * Estados del log.
     */
    public const ESTADOS = [
        'pendiente' => 'Pendiente',
        'enviado' => 'Enviado',
        'fallido' => 'Fallido',
        'rebotado' => 'Rebotado',
    ];

    // Relaciones

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(EmailCampaign::class, 'email_campaign_id');
    }

    public function faithfulMember(): BelongsTo
    {
        return $this->belongsTo(FaithfulMember::class);
    }

    // Scopes

    public function scopeEstado(Builder $query, string $estado): Builder
    {
        return $query->where('estado', $estado);
    }

    public function scopePendientes(Builder $query): Builder
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeEnviados(Builder $query): Builder
    {
        return $query->where('estado', 'enviado');
    }

    public function scopeFallidos(Builder $query): Builder
    {
        return $query->where('estado', 'fallido');
    }

    // Accessors

    public function getNombreEstadoAttribute(): string
    {
        return self::ESTADOS[$this->estado] ?? $this->estado;
    }

    public function getColorEstadoAttribute(): string
    {
        return match ($this->estado) {
            'pendiente' => 'gray',
            'enviado' => 'success',
            'fallido' => 'danger',
            'rebotado' => 'warning',
            default => 'gray',
        };
    }

    // Métodos

    /**
     * Marcar como enviado.
     */
    public function marcarEnviado(): void
    {
        $this->update([
            'estado' => 'enviado',
            'enviado_at' => now(),
        ]);
    }

    /**
     * Marcar como fallido.
     */
    public function marcarFallido(string $error): void
    {
        $this->update([
            'estado' => 'fallido',
            'error' => $error,
        ]);
    }
}
