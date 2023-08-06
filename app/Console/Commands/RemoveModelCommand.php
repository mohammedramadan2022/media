<?php

namespace App\Console\Commands;

use App\Facade\Support\Tools\Directory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RemoveModelCommand extends Command
{
    protected $signature = 'remove:model {model : the model name}
        {--T|translatable : this flag is optional}';

    protected $description = 'Remove Model Command description';

    public function handle(): void
    {
        $model = ucwords($this->argument('model'));

        if ($this->option('translatable')) {
            File::delete(app_path('/Models/'.$model.'Translation.php'));
        }

        File::delete(app_path('Models/'.$model.'.php'));

        File::delete(migrations_path('/'.Directory::migration(lower($model))));

        $this->components->info('Model Removed Successfully');
    }
}
