<?php

namespace App\Mail;

use App\Models\Postulation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NouvelleCandiature extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Postulation $postulation) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouvelle candidature — ' . $this->postulation->offre->nom,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.nouvelle_candidature',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
