<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class EmailTemplate extends Model
{
    protected $fillable = [
        'nombre',
        'slug',
        'asunto',
        'contenido',
        'tipo',
        'variables',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'variables' => 'array',
            'activo' => 'boolean',
        ];
    }

    /**
     * Tipos de plantilla disponibles.
     */
    public const TIPOS = [
        'newsletter' => 'Newsletter',
        'evento' => 'Evento',
        'aviso' => 'Aviso',
        'bienvenida' => 'Bienvenida',
        'personalizado' => 'Personalizado',
    ];

    /**
     * Variables disponibles para plantillas.
     */
    public const VARIABLES_DISPONIBLES = [
        '{{nombre}}' => 'Nombre del fiel',
        '{{apellidos}}' => 'Apellidos del fiel',
        '{{nombre_completo}}' => 'Nombre completo',
        '{{email}}' => 'Email del fiel',
        '{{capilla}}' => 'Capilla preferida',
        '{{fecha_actual}}' => 'Fecha actual',
        '{{nombre_parroquia}}' => 'Nombre de la parroquia',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($template) {
            if (empty($template->slug)) {
                $template->slug = Str::slug($template->nombre);
            }
        });
    }

    // Relaciones

    public function campaigns(): HasMany
    {
        return $this->hasMany(EmailCampaign::class);
    }

    // Scopes

    public function scopeActivo(Builder $query): Builder
    {
        return $query->where('activo', true);
    }

    public function scopeTipo(Builder $query, string $tipo): Builder
    {
        return $query->where('tipo', $tipo);
    }

    // Accessors

    public function getNombreTipoAttribute(): string
    {
        return self::TIPOS[$this->tipo] ?? $this->tipo;
    }

    // Métodos

    /**
     * Procesar contenido reemplazando variables.
     */
    public function procesarContenido(FaithfulMember $fiel): string
    {
        $contenido = $this->contenido;

        $reemplazos = [
            '{{nombre}}' => $fiel->nombre,
            '{{apellidos}}' => $fiel->apellidos,
            '{{nombre_completo}}' => $fiel->nombre_completo,
            '{{email}}' => $fiel->email,
            '{{capilla}}' => $fiel->chapel?->nombre ?? 'Templo Principal',
            '{{fecha_actual}}' => now()->format('d/m/Y'),
            '{{nombre_parroquia}}' => config('app.name'),
        ];

        return str_replace(
            array_keys($reemplazos),
            array_values($reemplazos),
            $contenido
        );
    }

    /**
     * Procesar asunto reemplazando variables.
     */
    public function procesarAsunto(FaithfulMember $fiel): string
    {
        $asunto = $this->asunto;

        $reemplazos = [
            '{{nombre}}' => $fiel->nombre,
            '{{nombre_completo}}' => $fiel->nombre_completo,
            '{{fecha_actual}}' => now()->format('d/m/Y'),
        ];

        return str_replace(
            array_keys($reemplazos),
            array_values($reemplazos),
            $asunto
        );
    }
}
