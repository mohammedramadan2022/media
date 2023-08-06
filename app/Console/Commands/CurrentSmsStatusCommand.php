<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CurrentSmsStatusCommand extends Command
{
    protected $signature = 'sms:current';

    protected $description = 'Get Current SMS Status Command description';

    public function handle(): void
    {
        $current_status = config('sms.sms_provider_status') ? 'ON' : 'OFF';

        $this->components->info('Current status is : ' . $current_status);
    }
}
