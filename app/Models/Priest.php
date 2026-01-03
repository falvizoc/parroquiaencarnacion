<?php

namespace App\Models;

use App\Traits\HasAiTranslation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Priest extends Model
{
    use HasAiTranslation;

    /**
     * Campos traducibles automáticamente.
     */
    public array $translatable = ['nombre', 'slug', 'cargo', 'titulo', 'mensaje', 'biografia'];

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
            $cargoEs = is_array($priest->cargo) ? ($priest->cargo['es'] ?? '') : $priest->getTranslation('cargo', 'es');
            if ($cargoEs === 'parroco' && $priest->activo) {
                $existingParroco = static::where('cargo->es', 'parroco')
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
        return $query->orderByRaw("CASE WHEN JSON_EXTRACT(cargo, '$.es') = 'parroco' THEN 0 ELSE 1 END")
                     ->orderBy('orden')
                     ->orderBy('nombre');
    }

    public function scopeParroco(Builder $query): Builder
    {
        return $query->where('cargo->es', 'parroco');
    }

    public function scopeVicarios(Builder $query): Builder
    {
        return $query->where('cargo->es', 'vicario');
    }

    // Accessors
    public function getNombreCargoAttribute(): string
    {
        $cargoEs = $this->getTranslation('cargo', 'es');
        return self::CARGOS[$cargoEs] ?? $this->cargo;
    }

    public function getNombreTituloAttribute(): string
    {
        $tituloEs = $this->getTranslation('titulo', 'es');
        return self::TITULOS[$tituloEs] ?? '';
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
        return $this->getTranslation('cargo', 'es') === 'parroco';
    }
}
