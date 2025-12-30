<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class FaithfulMember extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'fecha_nacimiento',
        'genero',
        'email',
        'telefono',
        'telefono_emergencia',
        'direccion',
        'colonia',
        'codigo_postal',
        'chapel_id',
        'fecha_bautismo',
        'fecha_confirmacion',
        'fecha_primera_comunion',
        'estado_civil',
        'notas',
        'activo',
        'email_verificado_at',
        'token_verificacion',
        'recibir_newsletter',
        'recibir_eventos',
        'recibir_avisos',
        'preferencias_adicionales',
        'token_preferencias',
    ];

    protected function casts(): array
    {
        return [
            'fecha_nacimiento' => 'date',
            'fecha_bautismo' => 'date',
            'fecha_confirmacion' => 'date',
            'fecha_primera_comunion' => 'date',
            'activo' => 'boolean',
            'email_verificado_at' => 'datetime',
            'recibir_newsletter' => 'boolean',
            'recibir_eventos' => 'boolean',
            'recibir_avisos' => 'boolean',
            'preferencias_adicionales' => 'array',
        ];
    }

    /**
     * Géneros disponibles.
     */
    public const GENEROS = [
        'masculino' => 'Masculino',
        'femenino' => 'Femenino',
        'otro' => 'Prefiero no decir',
    ];

    /**
     * Estados civiles disponibles.
     */
    public const ESTADOS_CIVILES = [
        'soltero' => 'Soltero(a)',
        'casado_iglesia' => 'Casado(a) por la Iglesia',
        'casado_civil' => 'Casado(a) solo civil',
        'divorciado' => 'Divorciado(a)',
        'viudo' => 'Viudo(a)',
        'union_libre' => 'Unión libre',
    ];

    // Relaciones

    /**
     * Capilla preferida del fiel.
     */
    public function chapel(): BelongsTo
    {
        return $this->belongsTo(Chapel::class);
    }

    /**
     * Grupos parroquiales a los que pertenece.
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(ParishGroup::class, 'faithful_member_parish_group')
            ->withPivot('fecha_ingreso', 'rol', 'activo')
            ->withTimestamps();
    }

    // Accessors

    /**
     * Nombre completo del fiel.
     */
    public function getNombreCompletoAttribute(): string
    {
        $partes = [$this->nombre, $this->apellido_paterno];

        if ($this->apellido_materno) {
            $partes[] = $this->apellido_materno;
        }

        return implode(' ', $partes);
    }

    /**
     * Apellidos completos.
     */
    public function getApellidosAttribute(): string
    {
        return trim($this->apellido_paterno . ' ' . ($this->apellido_materno ?? ''));
    }

    /**
     * Edad del fiel.
     */
    public function getEdadAttribute(): ?int
    {
        return $this->fecha_nacimiento?->age;
    }

    /**
     * Nombre del género.
     */
    public function getNombreGeneroAttribute(): string
    {
        return self::GENEROS[$this->genero] ?? 'No especificado';
    }

    /**
     * Nombre del estado civil.
     */
    public function getNombreEstadoCivilAttribute(): string
    {
        return self::ESTADOS_CIVILES[$this->estado_civil] ?? 'No especificado';
    }

    /**
     * Verificar si el email está verificado.
     */
    public function getEstaVerificadoAttribute(): bool
    {
        return $this->email_verificado_at !== null;
    }

    // Scopes

    /**
     * Fieles activos.
     */
    public function scopeActivo(Builder $query): Builder
    {
        return $query->where('activo', true);
    }

    /**
     * Fieles con email verificado.
     */
    public function scopeVerificado(Builder $query): Builder
    {
        return $query->whereNotNull('email_verificado_at');
    }

    /**
     * Fieles que aceptan newsletter.
     */
    public function scopeConNewsletter(Builder $query): Builder
    {
        return $query->where('recibir_newsletter', true);
    }

    /**
     * Fieles que aceptan avisos de eventos.
     */
    public function scopeConEventos(Builder $query): Builder
    {
        return $query->where('recibir_eventos', true);
    }

    /**
     * Fieles que aceptan avisos generales.
     */
    public function scopeConAvisos(Builder $query): Builder
    {
        return $query->where('recibir_avisos', true);
    }

    /**
     * Buscar por nombre o email.
     */
    public function scopeBuscar(Builder $query, string $termino): Builder
    {
        return $query->where(function ($q) use ($termino) {
            $q->where('nombre', 'like', "%{$termino}%")
                ->orWhere('apellido_paterno', 'like', "%{$termino}%")
                ->orWhere('apellido_materno', 'like', "%{$termino}%")
                ->orWhere('email', 'like', "%{$termino}%");
        });
    }

    /**
     * Ordenar por nombre completo.
     */
    public function scopeOrdenado(Builder $query): Builder
    {
        return $query->orderBy('apellido_paterno')
            ->orderBy('apellido_materno')
            ->orderBy('nombre');
    }

    // Métodos

    /**
     * Generar token de verificación.
     */
    public function generarTokenVerificacion(): string
    {
        $this->token_verificacion = Str::random(64);
        $this->save();

        return $this->token_verificacion;
    }

    /**
     * Verificar email con token.
     */
    public function verificarEmail(string $token): bool
    {
        if ($this->token_verificacion === $token) {
            $this->email_verificado_at = now();
            $this->token_verificacion = null;
            $this->save();

            return true;
        }

        return false;
    }

    /**
     * Verificar si puede recibir comunicación de cierto tipo.
     */
    public function puedeRecibir(string $tipo): bool
    {
        if (!$this->activo || !$this->esta_verificado) {
            return false;
        }

        return match ($tipo) {
            'newsletter' => $this->recibir_newsletter,
            'eventos' => $this->recibir_eventos,
            'avisos' => $this->recibir_avisos,
            default => false,
        };
    }

    /**
     * Generar token de preferencias (para gestión de suscripción).
     */
    public function generarTokenPreferencias(): string
    {
        if (!$this->token_preferencias) {
            $this->token_preferencias = Str::random(64);
            $this->save();
        }

        return $this->token_preferencias;
    }

    /**
     * Obtener URL de gestión de preferencias.
     */
    public function getUrlPreferenciasAttribute(): string
    {
        return route('preferencias', ['token' => $this->generarTokenPreferencias()]);
    }

    /**
     * Obtener URL de cancelación de suscripción.
     */
    public function getUrlCancelarSuscripcionAttribute(): string
    {
        return route('cancelar-suscripcion', ['token' => $this->generarTokenPreferencias()]);
    }
}
