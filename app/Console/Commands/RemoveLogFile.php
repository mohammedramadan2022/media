<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RemoveLogFile extends Command
{
    protected $signature = 'app:remove-log-file';

    protected $description = 'Command description';

    public function handle(): void
    {
        $path = base_path_normalized('/storage/logs/laravel.log');

        File::delete($path);

        $this->components->info('Log File Deleted Successfully !!');
    }
}
