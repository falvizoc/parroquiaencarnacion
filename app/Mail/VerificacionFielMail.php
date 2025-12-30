<?php

namespace App\Mail;

use App\Models\FaithfulMember;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerificacionFielMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public FaithfulMember $fiel
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('Verifica tu registro - Parroquia Nuestra Señora de la Encarnación'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.verificacion-fiel',
            with: [
                'nombre' => $this->fiel->nombre,
                'urlVerificacion' => $this->generarUrlVerificacion(),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    /**
     * Generar URL de verificación con firma.
     */
    protected function generarUrlVerificacion(): string
    {
        return route('verificar.email', [
            'locale' => app()->getLocale(),
            'id' => $this->fiel->id,
            'token' => $this->fiel->token_verificacion,
        ]);
    }
}
