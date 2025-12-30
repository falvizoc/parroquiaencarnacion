<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CryptCampaign extends Model
{
    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen_banner',
        'color_fondo',
        'fecha_inicio',
        'fecha_fin',
        'texto_boton',
        'url_boton',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'fecha_inicio' => 'date',
            'fecha_fin' => 'date',
            'activo' => 'boolean',
        ];
    }

    // Scopes

    public function scopeActivo(Builder $query): Builder
    {
        return $query->where('activo', true);
    }

    public function scopeVigente(Builder $query): Builder
    {
        $hoy = now()->toDateString();
        return $query->where('fecha_inicio', '<=', $hoy)
                     ->where('fecha_fin', '>=', $hoy);
    }

    // Accessors

    /**
     * Verificar si la campaña está vigente.
     */
    public function getEstaVigenteAttribute(): bool
    {
        $hoy = now()->startOfDay();
        return $this->activo
            && $this->fecha_inicio <= $hoy
            && $this->fecha_fin >= $hoy;
    }

    /**
     * Días restantes de la campaña.
     */
    public function getDiasRestantesAttribute(): int
    {
        if (!$this->esta_vigente) {
            return 0;
        }

        return now()->startOfDay()->diffInDays($this->fecha_fin, false);
    }

    // Métodos estáticos

    /**
     * Obtener campaña vigente actual.
     */
    public static function obtenerVigente(): ?self
    {
        return static::activo()->vigente()->first();
    }
}
