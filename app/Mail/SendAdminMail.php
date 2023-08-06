<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Env;

class SendAdminMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public mixed $message;

    public function __construct($message, $title)
    {
        $this->message = $message;

        $this->subject = $title;

        $this->from(Env::get('MAIL_FROM_ADDRESS'), Env::get('MAIL_FROM_NAME'));
    }

    public function build()
    {
        return $this->markdown('emails.sendAdminMail');
    }
}
