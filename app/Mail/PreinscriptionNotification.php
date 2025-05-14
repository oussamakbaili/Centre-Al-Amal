<?php

namespace App\Mail;

use App\Models\Preinscription;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PreinscriptionNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $preinscription;

    public function __construct(Preinscription $preinscription)
    {
        $this->preinscription = $preinscription;
    }

    public function build()
    {
        return $this->subject('Nouvelle Préinscription')
                    ->view('emails.preinscription_notification');
    }
}