<?php

namespace App\Livewire;

use App\Models\Chapel;
use App\Models\FaithfulMember;
use Illuminate\Support\Str;
use Livewire\Component;

class RegistroFiel extends Component
{
    // Paso actual del formulario
    public int $paso = 1;
    public int $totalPasos = 3;

    // Datos personales (Paso 1)
    public string $nombre = '';
    public string $apellido_paterno = '';
    public string $apellido_materno = '';
    public ?string $fecha_nacimiento = null;
    public ?string $genero = null;

    // Contacto (Paso 2)
    public string $email = '';
    public string $telefono = '';
    public string $direccion = '';
    public string $colonia = '';
    public string $codigo_postal = '';

    // Preferencias (Paso 3)
    public ?string $chapel_id = null;
    public bool $recibir_newsletter = true;
    public bool $recibir_eventos = true;
    public bool $recibir_avisos = true;
    public bool $acepta_privacidad = false;

    // Estado
    public bool $registroCompletado = false;
    public ?FaithfulMember $fielRegistrado = null;

    protected function rules(): array
    {
        return [
            // Paso 1
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date|before:today',
            'genero' => 'nullable|in:masculino,femenino,otro',

            // Paso 2
            'email' => 'required|email|unique:faithful_members,email|max:255',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:500',
            'colonia' => 'nullable|string|max:255',
            'codigo_postal' => 'nullable|string|max:10',

            // Paso 3
            'chapel_id' => 'nullable|exists:chapels,id',
            'recibir_newsletter' => 'boolean',
            'recibir_eventos' => 'boolean',
            'recibir_avisos' => 'boolean',
            'acepta_privacidad' => 'accepted',
        ];
    }

    protected function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'apellido_paterno.required' => 'El apellido paterno es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Ingresa un correo electrónico válido.',
            'email.unique' => 'Este correo ya está registrado.',
            'fecha_nacimiento.before' => 'La fecha de nacimiento debe ser anterior a hoy.',
            'acepta_privacidad.accepted' => 'Debes aceptar el aviso de privacidad.',
        ];
    }

    public function siguientePaso(): void
    {
        $this->validarPasoActual();

        if ($this->paso < $this->totalPasos) {
            $this->paso++;
        }
    }

    public function pasoAnterior(): void
    {
        if ($this->paso > 1) {
            $this->paso--;
        }
    }

    public function irAPaso(int $paso): void
    {
        if ($paso <= $this->paso && $paso >= 1) {
            $this->paso = $paso;
        }
    }

    protected function validarPasoActual(): void
    {
        $reglas = match ($this->paso) {
            1 => [
                'nombre' => $this->rules()['nombre'],
                'apellido_paterno' => $this->rules()['apellido_paterno'],
                'apellido_materno' => $this->rules()['apellido_materno'],
                'fecha_nacimiento' => $this->rules()['fecha_nacimiento'],
                'genero' => $this->rules()['genero'],
            ],
            2 => [
                'email' => $this->rules()['email'],
                'telefono' => $this->rules()['telefono'],
                'direccion' => $this->rules()['direccion'],
                'colonia' => $this->rules()['colonia'],
                'codigo_postal' => $this->rules()['codigo_postal'],
            ],
            3 => [
                'chapel_id' => $this->rules()['chapel_id'],
                'acepta_privacidad' => $this->rules()['acepta_privacidad'],
            ],
            default => [],
        };

        $this->validate($reglas);
    }

    public function registrar(): void
    {
        $this->validate();

        $fiel = FaithfulMember::create([
            'nombre' => $this->nombre,
            'apellido_paterno' => $this->apellido_paterno,
            'apellido_materno' => $this->apellido_materno ?: null,
            'fecha_nacimiento' => $this->fecha_nacimiento ?: null,
            'genero' => $this->genero ?: null,
            'email' => $this->email,
            'telefono' => $this->telefono ?: null,
            'direccion' => $this->direccion ?: null,
            'colonia' => $this->colonia ?: null,
            'codigo_postal' => $this->codigo_postal ?: null,
            'chapel_id' => $this->chapel_id ?: null,
            'recibir_newsletter' => $this->recibir_newsletter,
            'recibir_eventos' => $this->recibir_eventos,
            'recibir_avisos' => $this->recibir_avisos,
            'token_verificacion' => Str::random(64),
            'activo' => true,
        ]);

        $this->fielRegistrado = $fiel;
        $this->registroCompletado = true;

        // TODO: Enviar email de verificación
        // Mail::to($fiel->email)->send(new VerificacionEmail($fiel));
    }

    public function getCapillasProperty(): array
    {
        return Chapel::activo()->ordenado()->pluck('nombre', 'id')->toArray();
    }

    public function render()
    {
        return view('livewire.registro-fiel');
    }
}
