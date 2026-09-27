<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject('Nouveau message de contact - SchoolRDV : ' . $this->data['sujet'])
                    ->replyTo($this->data['email'], $this->data['nom']) // Permet de répondre directement à l'expéditeur (ex: Lazreg)
                    ->view('emails.contact');
    }
}