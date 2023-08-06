<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RemoveBladeFiles extends Command
{
    protected $signature = 'remove:blade {path}';

    protected $description = 'Remove Blade Files Command Description';

    public function handle(): void
    {
        $path = resource_path('Views/Back/'.ucwords($this->argument('path')));

        if (! File::isDirectory($path)) {
            $this->components->error('Directory is not found or deleted');

            return;
        }

        File::deleteDirectory($path);

        $this->components->info('Directory deleted successfully');
    }
}
