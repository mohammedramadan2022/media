<?php

namespace App\Jobs;

use App\Mail\SendAdminMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};
use Illuminate\Support\Facades\Mail;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public $message, public $to) {}

    public function handle(): void
    {
        Mail::to($this->to)->send(new SendAdminMail($this->message, 'New Mail'));
    }
}
