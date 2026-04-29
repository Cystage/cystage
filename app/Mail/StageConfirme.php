<?php

namespace App\Mail;

use App\Models\Postulation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StageConfirme extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Postulation $postulation) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Stage confirmé — ' . $this->postulation->offre->nom,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.stage_confirme',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
