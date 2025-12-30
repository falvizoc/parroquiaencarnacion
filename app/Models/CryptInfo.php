<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CryptInfo extends Model
{
    protected $fillable = [
        'titulo',
        'subtitulo',
        'descripcion',
        'descripcion_corta',
        'imagen',
        'telefono_contacto',
        'email_contacto',
        'horario_atencion',
        'mostrar_en_inicio',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'mostrar_en_inicio' => 'boolean',
            'activo' => 'boolean',
        ];
    }

    // Scopes

    public function scopeActivo(Builder $query): Builder
    {
        return $query->where('activo', true);
    }

    public function scopeMostrarEnInicio(Builder $query): Builder
    {
        return $query->where('mostrar_en_inicio', true);
    }

    // Métodos estáticos

    /**
     * Obtener la información de criptas activa.
     */
    public static function obtenerActiva(): ?self
    {
        return static::activo()->first();
    }

    /**
     * Obtener información para mostrar en inicio.
     */
    public static function paraInicio(): ?self
    {
        return static::activo()->mostrarEnInicio()->first();
    }
}
