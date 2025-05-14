<?php

namespace App\Mail;

use App\Models\Etudiant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EtudiantRegistered extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $password;
    
    /**
     * Create a new message instance.
     */
    public function __construct(Etudiant $etudiant, $password)
    {
        $this->email = $etudiant->email;
        $this->password = $password;
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Etudiant Registered',
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

    public function build()
    {
        return $this->subject('Vos informations de connexion')
                    ->view('emails.etudiant_registered')
                    ->with([
                        'email' => $this->email,
                        'password' => $this->password
                    ]);
    }
}
