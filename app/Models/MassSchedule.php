<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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
        'dia_semana',
        'hora',
        'tipo',
        'descripcion',
        'ubicacion',
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
