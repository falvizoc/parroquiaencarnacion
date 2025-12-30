<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class News extends Model
{
    use HasFactory;
    protected $fillable = [
        'titulo',
        'slug',
        'extracto',
        'contenido',
        'imagen',
        'fecha_publicacion',
        'autor',
        'categoria',
        'es_destacado',
        'activo',
    ];

    protected $casts = [
        'fecha_publicacion' => 'datetime',
        'es_destacado' => 'boolean',
        'activo' => 'boolean',
    ];

    public const CATEGORIAS = [
        'parroquia' => 'Parroquia',
        'diocesis' => 'Diócesis',
        'papa' => 'Papa Francisco',
        'comunidad' => 'Comunidad',
        'general' => 'General',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($news) {
            if (empty($news->slug)) {
                $news->slug = Str::slug($news->titulo);
            }
            if (empty($news->fecha_publicacion)) {
                $news->fecha_publicacion = now();
            }
        });
    }

    // Scopes
    public function scopeActivo(Builder $query): Builder
    {
        return $query->where('activo', true);
    }

    public function scopePublicado(Builder $query): Builder
    {
        return $query->where('fecha_publicacion', '<=', now());
    }

    public function scopeDestacado(Builder $query): Builder
    {
        return $query->where('es_destacado', true);
    }

    public function scopeReciente(Builder $query): Builder
    {
        return $query->orderByDesc('fecha_publicacion');
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
        return $this->fecha_publicacion->translatedFormat('d \d\e F, Y');
    }

    public function getTiempoLecturaAttribute(): int
    {
        $palabras = str_word_count(strip_tags($this->contenido));
        return max(1, ceil($palabras / 200));
    }
}
