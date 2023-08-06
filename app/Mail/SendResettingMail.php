<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendResettingMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public mixed $token) {}

    public function build()
    {
        return $this->markdown('Back.Mails.sendResetMail')->with(['token' => $this->token]);
    }
}
