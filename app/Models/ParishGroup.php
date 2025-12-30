<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ParishGroup extends Model
{
    protected $fillable = [
        'chapel_id',
        'nombre',
        'slug',
        'descripcion_corta',
        'descripcion',
        'imagen',
        'dia_reunion',
        'hora_reunion',
        'lugar_reunion',
        'coordinador_nombre',
        'coordinador_telefono',
        'coordinador_email',
        'activo',
        'orden',
    ];

    protected $casts = [
        'dia_reunion' => 'integer',
        'hora_reunion' => 'datetime:H:i',
        'activo' => 'boolean',
        'orden' => 'integer',
    ];

    public const DIAS_SEMANA = [
        0 => 'Domingo',
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miércoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sábado',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($group) {
            if (empty($group->slug)) {
                $group->slug = Str::slug($group->nombre);
            }
        });
    }

    // Relationships
    public function chapel(): BelongsTo
    {
        return $this->belongsTo(Chapel::class);
    }

    // Scopes
    public function scopeActivo(Builder $query): Builder
    {
        return $query->where('activo', true);
    }

    public function scopeOrdenado(Builder $query): Builder
    {
        return $query->orderBy('orden')->orderBy('nombre');
    }

    public function scopeParroquiaPrincipal(Builder $query): Builder
    {
        return $query->whereNull('chapel_id');
    }

    public function scopeDeCapilla(Builder $query, int $chapelId): Builder
    {
        return $query->where('chapel_id', $chapelId);
    }

    // Accessors
    public function getNombreUbicacionAttribute(): string
    {
        return $this->chapel ? $this->chapel->nombre : 'Parroquia Principal';
    }

    public function getNombreDiaReunionAttribute(): ?string
    {
        return $this->dia_reunion !== null
            ? self::DIAS_SEMANA[$this->dia_reunion] ?? null
            : null;
    }

    public function getHorarioFormateadoAttribute(): ?string
    {
        if (!$this->dia_reunion && !$this->hora_reunion) {
            return null;
        }

        $partes = [];

        if ($this->dia_reunion !== null) {
            $partes[] = $this->nombre_dia_reunion;
        }

        if ($this->hora_reunion) {
            $partes[] = $this->hora_reunion->format('g:i A');
        }

        return implode(' - ', $partes);
    }

    public function getImagenUrlAttribute(): ?string
    {
        return $this->imagen ? asset('storage/' . $this->imagen) : null;
    }
}
