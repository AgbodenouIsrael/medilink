<?php

namespace App\Mail;

use App\Models\Medecin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewDoctorRegistration extends Mailable
{
    use Queueable, SerializesModels;

    public $medecin;

    /**
     * Create a new message instance.
     */
    public function __construct(Medecin $medecin)
    {
        $this->medecin = $medecin;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouvel Inscription Médecin - Vérification Requise',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.new_doctor_registration',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
