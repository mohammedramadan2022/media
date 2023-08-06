<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendResetCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public mixed $message) {}

    public function build()
    {
        return $this->markdown('emails.sendResetCodeMail');
    }
}
