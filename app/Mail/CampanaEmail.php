<?php

namespace App\Mail;

use App\Models\EmailCampaign;
use App\Models\FaithfulMember;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CampanaEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $asunto,
        public string $contenido,
        public FaithfulMember $fiel,
        public EmailCampaign $campana
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->asunto,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.campana',
            with: [
                'contenido' => $this->contenido,
                'fiel' => $this->fiel,
                'campana' => $this->campana,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
