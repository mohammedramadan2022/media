<?php

namespace App\Console\Commands;

use App\Facade\Support\Core\Stub;
use Illuminate\Console\Command;

class MakeTranslationModelCommand extends Command
{
    protected $signature = 'make:translation {model}';

    protected $description = 'Make Translation Model Command';

    public function handle(): void
    {
        $model = $this->argument('model');

        Stub::createTranslatableMigration(lower($model)->plural());

        Stub::of('App\Models', $model,'model.translatable.stub',ucwords($model).'.php');

        Stub::of('App\Models', $model,'model.translation.stub',ucwords($model).'Translation.php');

        $this->components->info('Model Created Successfully');
    }
}
