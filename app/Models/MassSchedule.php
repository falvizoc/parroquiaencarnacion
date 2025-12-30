<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MassSchedule extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla.
     */
    protected $table = 'mass_schedules';

    /**
     * Atributos asignables masivamente.
     */
    protected $fillable = [
        'chapel_id',
        'dia_semana',
        'hora',
        'tipo',
        'descripcion',
        'idioma',
        'activo',
        'notas',
        'orden',
    ];

    /**
     * Casteo de atributos.
     */
    protected function casts(): array
    {
        return [
            'dia_semana' => 'integer',
            'hora' => 'datetime:H:i',
            'activo' => 'boolean',
            'orden' => 'integer',
        ];
    }

    /**
     * Tipos de misa disponibles.
     */
    public const TIPOS = [
        'ordinaria' => 'Ordinaria',
        'dominical' => 'Dominical',
        'vespertina' => 'Vespertina',
        'especial' => 'Especial',
    ];

    /**
     * Días de la semana.
     */
    public const DIAS_SEMANA = [
        0 => 'Domingo',
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miércoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sábado',
    ];

    /**
     * Relación con capilla.
     */
    public function chapel(): BelongsTo
    {
        return $this->belongsTo(Chapel::class);
    }

    /**
     * Scope para horarios de la parroquia principal (sin capilla).
     */
    public function scopeParroquiaPrincipal(Builder $query): Builder
    {
        return $query->whereNull('chapel_id');
    }

    /**
     * Scope para horarios de una capilla específica.
     */
    public function scopeDeCapilla(Builder $query, int $chapelId): Builder
    {
        return $query->where('chapel_id', $chapelId);
    }

    /**
     * Scope para horarios activos (alias para consistencia).
     */
    public function scopeActivo(Builder $query): Builder
    {
        return $query->where('activo', true);
    }

    /**
     * Obtener el nombre de la ubicación (capilla o templo principal).
     */
    public function getNombreUbicacionAttribute(): string
    {
        return $this->chapel ? $this->chapel->nombre : 'Templo Principal';
    }

    /**
     * Obtener el nombre del día de la semana.
     */
    public function getNombreDiaAttribute(): string
    {
        return self::DIAS_SEMANA[$this->dia_semana] ?? 'Desconocido';
    }

    /**
     * Obtener la hora formateada.
     */
    public function getHoraFormateadaAttribute(): string
    {
        return $this->hora?->format('H:i') ?? '';
    }

    /**
     * Obtener el nombre del tipo de misa.
     */
    public function getNombreTipoAttribute(): string
    {
        return self::TIPOS[$this->tipo] ?? $this->tipo;
    }

    /**
     * Scope para horarios activos.
     */
    public function scopeActivos(Builder $query): Builder
    {
        return $query->where('activo', true);
    }

    /**
     * Scope para un día específico.
     */
    public function scopeDia(Builder $query, int $dia): Builder
    {
        return $query->where('dia_semana', $dia);
    }

    /**
     * Scope para ordenar por día y hora.
     */
    public function scopeOrdenados(Builder $query): Builder
    {
        return $query->orderBy('dia_semana')->orderBy('hora')->orderBy('orden');
    }

    /**
     * Obtener horarios agrupados por día.
     */
    public static function agrupadosPorDia(): array
    {
        $horarios = static::activos()->ordenados()->get();

        $agrupados = [];
        foreach (self::DIAS_SEMANA as $numeroDia => $nombreDia) {
            $agrupados[$numeroDia] = [
                'nombre' => $nombreDia,
                'horarios' => $horarios->where('dia_semana', $numeroDia)->values(),
            ];
        }

        return $agrupados;
    }
}
