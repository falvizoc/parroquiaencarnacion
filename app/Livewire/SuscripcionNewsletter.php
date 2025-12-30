<?php

namespace App\Livewire;

use App\Mail\VerificacionFielMail;
use App\Models\FaithfulMember;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class SuscripcionNewsletter extends Component
{
    public string $email = '';
    public string $nombre = '';
    public bool $recibir_newsletter = true;
    public bool $recibir_eventos = false;
    public bool $recibir_avisos = false;

    public bool $exito = false;
    public bool $yaRegistrado = false;
    public string $mensaje = '';

    protected function rules(): array
    {
        return [
            'email' => 'required|email|max:255',
            'nombre' => 'required|string|min:2|max:100',
            'recibir_newsletter' => 'boolean',
            'recibir_eventos' => 'boolean',
            'recibir_avisos' => 'boolean',
        ];
    }

    protected function messages(): array
    {
        return [
            'email.required' => 'El email es requerido.',
            'email.email' => 'Por favor ingresa un email válido.',
            'nombre.required' => 'El nombre es requerido.',
            'nombre.min' => 'El nombre debe tener al menos 2 caracteres.',
        ];
    }

    public function suscribirse(): void
    {
        $this->validate();

        // Verificar si al menos una opción está seleccionada
        if (!$this->recibir_newsletter && !$this->recibir_eventos && !$this->recibir_avisos) {
            $this->addError('preferencias', 'Debes seleccionar al menos un tipo de comunicación.');
            return;
        }

        // Buscar si ya existe el email
        $existente = FaithfulMember::where('email', $this->email)->first();

        if ($existente) {
            // Actualizar preferencias del existente
            $existente->update([
                'recibir_newsletter' => $this->recibir_newsletter,
                'recibir_eventos' => $this->recibir_eventos,
                'recibir_avisos' => $this->recibir_avisos,
            ]);

            if ($existente->email_verificado_at) {
                $this->yaRegistrado = true;
                $this->mensaje = 'Tus preferencias han sido actualizadas.';
            } else {
                // Reenviar verificación
                $existente->generarTokenVerificacion();
                Mail::to($existente->email)->queue(new VerificacionFielMail($existente));
                $this->mensaje = 'Te hemos reenviado el correo de verificación.';
            }
        } else {
            // Crear nuevo registro simplificado
            $fiel = FaithfulMember::create([
                'nombre' => $this->nombre,
                'apellido_paterno' => '', // Campo requerido pero vacío para suscripción simple
                'email' => $this->email,
                'recibir_newsletter' => $this->recibir_newsletter,
                'recibir_eventos' => $this->recibir_eventos,
                'recibir_avisos' => $this->recibir_avisos,
                'activo' => true,
            ]);

            // Generar token y enviar verificación
            $fiel->generarTokenVerificacion();
            Mail::to($fiel->email)->queue(new VerificacionFielMail($fiel));

            $this->mensaje = 'Te hemos enviado un correo de verificación. Por favor revisa tu bandeja de entrada.';
        }

        $this->exito = true;
    }

    public function render()
    {
        return view('livewire.suscripcion-newsletter');
    }
}
