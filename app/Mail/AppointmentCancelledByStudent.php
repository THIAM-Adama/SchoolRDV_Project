<?php

namespace App\Mail;

use App\Models\Rendezvous;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentCancelledByStudent extends Mailable
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
            subject: 'Confirmation d\'annulation de votre rendez-vous - SchoolRDV',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.appointments.cancelled_by_student',
        );
    }
}