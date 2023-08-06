<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CrudCommand extends Command
{
    protected $signature = 'make:crud {model : the model name} {--T|translatable : this flag is optional}';

    protected $description = 'Create a crud files';

    public function handle(): void
    {
        $model = ucwords($this->argument('model'));

        if ($this->option('translatable')) {
            Artisan::call('make:translation '.$model);
        } else {
            Artisan::call('make:model '.$model.' -m');
        }

        Artisan::call('make:trait '.$model);

        Artisan::call('make:api-trait '.$model);

        Artisan::call('make:scope '.$model);

        Artisan::call('make:controller Back/'.$model.'Controller --model='.$model);

        Artisan::call('make:request Back/Create'.$model.'Request');

        Artisan::call('make:request Back/Edit'.$model.'Request');

        Artisan::call('make:resource '.$model.'Resource');

        Artisan::call('make:contract '.$model);

        Artisan::call('make:blade '.$model);

        $this->components->info('The Crud created successfully');
    }
}
