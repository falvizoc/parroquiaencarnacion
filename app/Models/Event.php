<?php

namespace App\Models;

use App\Traits\HasAiTranslation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory, HasAiTranslation;

    /**
     * Campos traducibles automáticamente.
     */
    public array $translatable = ['titulo', 'slug', 'descripcion_corta', 'descripcion', 'lugar', 'direccion'];

    protected $fillable = [
        'titulo',
        'slug',
        'descripcion_corta',
        'descripcion',
        'imagen',
        'fecha_inicio',
        'fecha_fin',
        'hora_inicio',
        'hora_fin',
        'lugar',
        'direccion',
        'categoria',
        'es_destacado',
        'activo',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'hora_inicio' => 'datetime:H:i',
        'hora_fin' => 'datetime:H:i',
        'es_destacado' => 'boolean',
        'activo' => 'boolean',
    ];

    public const CATEGORIAS = [
        'liturgico' => 'Litúrgico',
        'social' => 'Social',
        'formacion' => 'Formación',
        'comunitario' => 'Comunitario',
        'general' => 'General',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($event) {
            if (empty($event->slug)) {
                $event->slug = Str::slug($event->titulo);
            }
        });
    }

    // Scopes
    public function scopeActivo(Builder $query): Builder
    {
        return $query->where('activo', true);
    }

    public function scopeDestacado(Builder $query): Builder
    {
        return $query->where('es_destacado', true);
    }

    public function scopeProximos(Builder $query): Builder
    {
        return $query->where('fecha_inicio', '>=', now()->startOfDay())
            ->orderBy('fecha_inicio')
            ->orderBy('hora_inicio');
    }

    public function scopePasados(Builder $query): Builder
    {
        return $query->where('fecha_inicio', '<', now()->startOfDay())
            ->orderByDesc('fecha_inicio');
    }

    public function scopeDelMes(Builder $query, ?int $mes = null, ?int $anio = null): Builder
    {
        $mes = $mes ?? now()->month;
        $anio = $anio ?? now()->year;

        return $query->whereMonth('fecha_inicio', $mes)
            ->whereYear('fecha_inicio', $anio);
    }

    // Accessors
    public function getNombreCategoriaAttribute(): string
    {
        return self::CATEGORIAS[$this->categoria] ?? 'General';
    }

    public function getImagenUrlAttribute(): ?string
    {
        return $this->imagen ? asset('storage/' . $this->imagen) : null;
    }

    public function getFechaFormateadaAttribute(): string
    {
        if ($this->fecha_fin && $this->fecha_fin->ne($this->fecha_inicio)) {
            return $this->fecha_inicio->translatedFormat('d M') . ' - ' . $this->fecha_fin->translatedFormat('d M, Y');
        }

        return $this->fecha_inicio->translatedFormat('d \d\e F, Y');
    }

    public function getHorarioFormateadoAttribute(): ?string
    {
        if (!$this->hora_inicio) {
            return null;
        }

        $horario = $this->hora_inicio->format('g:i A');

        if ($this->hora_fin) {
            $horario .= ' - ' . $this->hora_fin->format('g:i A');
        }

        return $horario;
    }

    public function getEsPasadoAttribute(): bool
    {
        $fechaFin = $this->fecha_fin ?? $this->fecha_inicio;
        return $fechaFin->lt(now()->startOfDay());
    }

    public function getEsHoyAttribute(): bool
    {
        return $this->fecha_inicio->isToday() ||
            ($this->fecha_fin && now()->between($this->fecha_inicio, $this->fecha_fin));
    }
}
