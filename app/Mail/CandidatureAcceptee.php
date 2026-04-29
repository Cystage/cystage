<?php

namespace App\Mail;

use App\Models\Postulation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CandidatureAcceptee extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Postulation $postulation) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre candidature a été acceptée — ' . $this->postulation->offre->nom,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.candidature_acceptee',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
