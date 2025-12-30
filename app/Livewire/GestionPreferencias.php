<?php

namespace App\Livewire;

use App\Models\FaithfulMember;
use Livewire\Component;

class GestionPreferencias extends Component
{
    public ?FaithfulMember $fiel = null;
    public string $token = '';

    public bool $recibir_newsletter = false;
    public bool $recibir_eventos = false;
    public bool $recibir_avisos = false;

    public bool $guardado = false;
    public bool $cancelado = false;
    public string $mensaje = '';

    public function mount(string $token = ''): void
    {
        $this->token = $token;

        if ($token) {
            $this->fiel = FaithfulMember::where('token_preferencias', $token)->first();

            if ($this->fiel) {
                $this->recibir_newsletter = $this->fiel->recibir_newsletter;
                $this->recibir_eventos = $this->fiel->recibir_eventos;
                $this->recibir_avisos = $this->fiel->recibir_avisos;
            }
        }
    }

    public function guardar(): void
    {
        if (!$this->fiel) {
            return;
        }

        $this->fiel->update([
            'recibir_newsletter' => $this->recibir_newsletter,
            'recibir_eventos' => $this->recibir_eventos,
            'recibir_avisos' => $this->recibir_avisos,
        ]);

        $this->guardado = true;
        $this->mensaje = 'Tus preferencias han sido actualizadas correctamente.';
    }

    public function cancelarTodo(): void
    {
        if (!$this->fiel) {
            return;
        }

        $this->fiel->update([
            'recibir_newsletter' => false,
            'recibir_eventos' => false,
            'recibir_avisos' => false,
            'activo' => false,
        ]);

        $this->cancelado = true;
        $this->mensaje = 'Te has dado de baja de todas las comunicaciones.';
    }

    public function render()
    {
        return view('livewire.gestion-preferencias');
    }
}
