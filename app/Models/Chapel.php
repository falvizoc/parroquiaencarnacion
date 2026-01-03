<?php

namespace App\Models;

use App\Traits\HasAiTranslation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Chapel extends Model
{
    use HasAiTranslation;

    /**
     * Campos traducibles automáticamente.
     */
    public array $translatable = ['nombre', 'slug', 'descripcion', 'direccion'];

    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'direccion',
        'telefono',
        'email',
        'imagen',
        'mapa_url',
        'latitud',
        'longitud',
        'activo',
        'orden',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'latitud' => 'decimal:8',
        'longitud' => 'decimal:8',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($chapel) {
            if (empty($chapel->slug)) {
                $chapel->slug = Str::slug($chapel->nombre);
            }
        });
    }

    // Relationships
    public function massSchedules(): HasMany
    {
        return $this->hasMany(MassSchedule::class);
    }

    public function parishGroups(): HasMany
    {
        return $this->hasMany(ParishGroup::class);
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

    // Accessors
    public function getImagenUrlAttribute(): ?string
    {
        return $this->imagen ? asset('storage/' . $this->imagen) : null;
    }

    public function getHorariosCountAttribute(): int
    {
        return $this->massSchedules()->activo()->count();
    }

    public function getGruposCountAttribute(): int
    {
        return $this->parishGroups()->activo()->count();
    }
}
