<?php

namespace App\Console\Commands;

use App\Facade\Support\Core\Stub;
use Illuminate\Console\Command;

class MakeContractCommand extends Command
{
    protected $signature = 'make:contract {model}';

    protected $description = 'Make Contract Command';

    public function handle(): void
    {
        self::createStub('App\Repository\Contracts', 'interface.stub', 'interface');

        self::createStub('App\Repository\Eloquent\Sql', 'repository.stub', 'eloquent');

        $this->components->info('Contract Created Successfully');
    }

    private function createStub($namespace, $filename, $type): void
    {
        $type = strtolower($type);

        $model = $this->argument('model');

        $name = ($type == 'interface') ? 'I'.ucwords($model).'Repository.php' : ucwords($model).'Repository.php';

        Stub::of($namespace, $model, $filename, $name);
    }
}
