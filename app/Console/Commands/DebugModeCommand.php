<?php

namespace App\Console\Commands;

use App\Facade\Support\Tools\Environment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DebugModeCommand extends Command
{
    protected $signature = 'debug:mode {value}';

    protected $description = 'Change the debug mode';

    public function handle(): void
    {
        $value = strtolower($this->argument('value'));

        if (! in_array($value, ['on', 'off'])) {
            $this->components->error('Please write value in [ on, off ]');

            return;
        }

        $new = $value == 'on';

        $app_env = $new ? 'local' : 'production';

        DB::table('settings')->where('key', '=', 'app_debug')->update(['value' => $new]);

        Environment::updateBool('APP_DEBUG', $new);

        Environment::updateBool('APP_ENV', $app_env);

        $this->components->info($new ? ' Debug Mode is enabled' : 'Debug Mode is disabled');
    }
}
