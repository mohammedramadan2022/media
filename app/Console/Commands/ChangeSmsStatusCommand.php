<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ChangeSmsStatusCommand extends Command
{
    protected $signature = 'sms:status {value}';

    protected $description = 'Change SMS status to be "ON" or "OFF" Command description';

    public function handle(): void
    {
        $value = strtolower($this->argument('value'));

        if (! in_array($value, ['on', 'off'])) {
            $this->components->error('The value must be ON or OFF');

            return;
        }

        $new_value = ($value == 'on') ? 'true' : 'false';

        $current_status = config('sms.sms_provider_status') ? 'true' : 'false';

        $old = "'sms_provider_status' => $current_status";

        $new = "'sms_provider_status' => $new_value";

        $path = base_path('config/sms.php');

        File::put($path, str_replace($old, $new, File::get($path)));

        $this->components->info('SMS Current status is : '.$new_value);
    }
}
