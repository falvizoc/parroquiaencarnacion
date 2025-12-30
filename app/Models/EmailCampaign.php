<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmailCampaign extends Model
{
    protected $fillable = [
        'nombre',
        'email_template_id',
        'asunto',
        'contenido',
        'tipo',
        'segmentacion',
        'estado',
        'programada_para',
        'enviada_at',
        'total_destinatarios',
        'enviados',
        'fallidos',
        'creado_por',
    ];

    protected function casts(): array
    {
        return [
            'segmentacion' => 'array',
            'programada_para' => 'datetime',
            'enviada_at' => 'datetime',
        ];
    }

    /**
     * Tipos de campaña.
     */
    public const TIPOS = [
        'newsletter' => 'Newsletter',
        'evento' => 'Evento',
        'aviso' => 'Aviso',
        'personalizado' => 'Personalizado',
    ];

    /**
     * Estados de la campaña.
     */
    public const ESTADOS = [
        'borrador' => 'Borrador',
        'programada' => 'Programada',
        'enviando' => 'Enviando',
        'enviada' => 'Enviada',
        'cancelada' => 'Cancelada',
    ];

    /**
     * Opciones de segmentación.
     */
    public const SEGMENTACION_OPCIONES = [
        'todos' => 'Todos los fieles verificados',
        'newsletter' => 'Suscritos a newsletter',
        'eventos' => 'Suscritos a eventos',
        'avisos' => 'Suscritos a avisos',
        'capilla' => 'Por capilla específica',
    ];

    // Relaciones

    public function template(): BelongsTo
    {
        return $this->belongsTo(EmailTemplate::class, 'email_template_id');
    }

    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creado_por');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(EmailLog::class);
    }

    // Scopes

    public function scopeEstado(Builder $query, string $estado): Builder
    {
        return $query->where('estado', $estado);
    }

    public function scopeBorrador(Builder $query): Builder
    {
        return $query->where('estado', 'borrador');
    }

    public function scopeProgramadas(Builder $query): Builder
    {
        return $query->where('estado', 'programada');
    }

    public function scopeEnviadas(Builder $query): Builder
    {
        return $query->where('estado', 'enviada');
    }

    // Accessors

    public function getNombreTipoAttribute(): string
    {
        return self::TIPOS[$this->tipo] ?? $this->tipo;
    }

    public function getNombreEstadoAttribute(): string
    {
        return self::ESTADOS[$this->estado] ?? $this->estado;
    }

    public function getColorEstadoAttribute(): string
    {
        return match ($this->estado) {
            'borrador' => 'gray',
            'programada' => 'warning',
            'enviando' => 'info',
            'enviada' => 'success',
            'cancelada' => 'danger',
            default => 'gray',
        };
    }

    public function getPorcentajeEnviadoAttribute(): float
    {
        if ($this->total_destinatarios === 0) {
            return 0;
        }

        return round(($this->enviados / $this->total_destinatarios) * 100, 1);
    }

    // Métodos

    /**
     * Obtener destinatarios según segmentación.
     */
    public function obtenerDestinatarios(): Builder
    {
        $query = FaithfulMember::activo()->verificado();

        $segmentacion = $this->segmentacion ?? [];

        // Filtrar por tipo de suscripción
        if (isset($segmentacion['tipo'])) {
            match ($segmentacion['tipo']) {
                'newsletter' => $query->conNewsletter(),
                'eventos' => $query->conEventos(),
                'avisos' => $query->conAvisos(),
                default => null,
            };
        }

        // Filtrar por capilla
        if (!empty($segmentacion['chapel_id'])) {
            $query->where('chapel_id', $segmentacion['chapel_id']);
        }

        return $query;
    }

    /**
     * Verificar si puede ser enviada.
     */
    public function puedeEnviarse(): bool
    {
        return in_array($this->estado, ['borrador', 'programada']);
    }

    /**
     * Verificar si puede ser cancelada.
     */
    public function puedeCancelarse(): bool
    {
        return in_array($this->estado, ['programada', 'enviando']);
    }

    /**
     * Marcar como enviando.
     */
    public function marcarEnviando(int $totalDestinatarios): void
    {
        $this->update([
            'estado' => 'enviando',
            'total_destinatarios' => $totalDestinatarios,
        ]);
    }

    /**
     * Marcar como enviada.
     */
    public function marcarEnviada(): void
    {
        $this->update([
            'estado' => 'enviada',
            'enviada_at' => now(),
        ]);
    }

    /**
     * Incrementar contador de enviados.
     */
    public function incrementarEnviados(): void
    {
        $this->increment('enviados');
    }

    /**
     * Incrementar contador de fallidos.
     */
    public function incrementarFallidos(): void
    {
        $this->increment('fallidos');
    }
}
