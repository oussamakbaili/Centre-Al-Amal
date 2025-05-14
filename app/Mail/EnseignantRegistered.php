<?php

namespace App\Mail;

use App\Models\Enseignant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnseignantRegistered extends Mailable
{
    use Queueable, SerializesModels;

    public $enseignant;
    public $password;

    /**
     * Create a new message instance.
     *
     * @param Enseignant $enseignant
     * @param string $password
     */
    public function __construct(Enseignant $enseignant, $password)
    {
        $this->enseignant = $enseignant;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Bienvenue sur notre plateforme')
                    ->view('emails.enseignant_registered');
    }
}