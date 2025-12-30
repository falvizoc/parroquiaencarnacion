<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Priest extends Model
{
    protected $fillable = [
        'nombre',
        'slug',
        'cargo',
        'titulo',
        'mensaje',
        'biografia',
        'foto',
        'email',
        'telefono',
        'fecha_ordenacion',
        'fecha_asignacion',
        'activo',
        'orden',
    ];

    protected $casts = [
        'fecha_ordenacion' => 'date',
        'fecha_asignacion' => 'date',
        'activo' => 'boolean',
    ];

    public const CARGOS = [
        'parroco' => 'Párroco',
        'vicario' => 'Vicario',
    ];

    public const TITULOS = [
        'pbro' => 'Pbro.',
        'mons' => 'Mons.',
        'padre' => 'P.',
        'fray' => 'Fray',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($priest) {
            if (empty($priest->slug)) {
                $priest->slug = Str::slug($priest->nombre);
            }
        });

        // Validate only one parroco can exist
        static::saving(function ($priest) {
            if ($priest->cargo === 'parroco' && $priest->activo) {
                $existingParroco = static::where('cargo', 'parroco')
                    ->where('activo', true)
                    ->where('id', '!=', $priest->id ?? 0)
                    ->exists();

                if ($existingParroco) {
                    throw new \Exception('Solo puede existir un párroco activo. Desactive el párroco actual antes de asignar uno nuevo.');
                }
            }
        });
    }

    // Scopes
    public function scopeActivo(Builder $query): Builder
    {
        return $query->where('activo', true);
    }

    public function scopeOrdenado(Builder $query): Builder
    {
        return $query->orderByRaw("CASE WHEN cargo = 'parroco' THEN 0 ELSE 1 END")
                     ->orderBy('orden')
                     ->orderBy('nombre');
    }

    public function scopeParroco(Builder $query): Builder
    {
        return $query->where('cargo', 'parroco');
    }

    public function scopeVicarios(Builder $query): Builder
    {
        return $query->where('cargo', 'vicario');
    }

    // Accessors
    public function getNombreCargoAttribute(): string
    {
        return self::CARGOS[$this->cargo] ?? $this->cargo;
    }

    public function getNombreTituloAttribute(): string
    {
        return self::TITULOS[$this->titulo] ?? '';
    }

    public function getNombreCompletoAttribute(): string
    {
        $titulo = $this->nombre_titulo;
        return $titulo ? "{$titulo} {$this->nombre}" : $this->nombre;
    }

    public function getFotoUrlAttribute(): ?string
    {
        return $this->foto ? asset('storage/' . $this->foto) : null;
    }

    public function getAnosOrdenadoAttribute(): ?int
    {
        return $this->fecha_ordenacion ? $this->fecha_ordenacion->diffInYears(now()) : null;
    }

    public function isParroco(): bool
    {
        return $this->cargo === 'parroco';
    }
}
