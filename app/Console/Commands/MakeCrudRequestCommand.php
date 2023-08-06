<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MakeCrudRequestCommand extends Command
{
    protected $signature = 'make:crud-requests {model : the model name}';

    protected $description = 'Create a crud request files';

    public function handle(): void
    {
        $model = $this->argument('model');

        Artisan::call('make:request Back/Create'.ucwords($model).'Request');

        Artisan::call('make:request Back/Edit'.ucwords($model).'Request');

        $this->components->info('The Crud Requests created successfully');
    }
}
