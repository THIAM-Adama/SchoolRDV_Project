<?php

namespace App\Mail;

use App\Models\Rendezvous;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RendezVousAnnuleMail extends Mailable
{
    use Queueable, SerializesModels;

    public $rendezvous;

    public function __construct(Rendezvous $rendezvous)
    {
        $this->rendezvous = $rendezvous;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Annulation de votre rendez-vous - SchoolRDV',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.rendezvous_annule',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}