<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RemoveResource extends Command
{
    protected $signature = 'remove:resource {name}';

    protected $description = 'Remove Resource File Command';

    public function handle()
    {
        $path = app_path('Http/Resources/'.ucwords($this->argument('name')).'.php');

        if (! File::exists($path)) {
            $this->components->error('File is not found or deleted !!');

            return;
        }

        File::delete($path);

        $this->components->info('File Removed Successfully');
    }
}
