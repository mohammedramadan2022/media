<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Env;

class SendProviderResetMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public mixed $token;

    public function __construct($token, $title)
    {
        $this->token = $token;

        $this->subject = $title;

        $this->from(Env::get('MAIL_FROM_ADDRESS'), Env::get('MAIL_FROM_NAME'));
    }

    public function build()
    {
        return $this->markdown('Back.Mails.sendProviderResetMail')->with(['token' => $this->token]);
    }
}
