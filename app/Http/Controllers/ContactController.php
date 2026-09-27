<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'nom'     => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'sujet'   => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        // Envoi du mail à l'administrateur
        Mail::to(config('mail.from.address', 'admin@schoolrdv.fr'))->send(new ContactMessageMail($validated));

        return back()->with('success', 'Votre message a été envoyé avec succès ! Nous vous répondrons dans les plus brefs délais.');
    }
}