<?php

namespace App\Console\Commands;

use App\Facade\Support\Core\Stub;
use Illuminate\Console\Command;

class MakeApiTraitCommand extends Command
{
    protected $signature = 'make:api-trait {name}';

    protected $description = 'Create api trait file';

    public function handle(): void
    {
        $namespace = 'App\Http\Traits\Api';

        $name = singular($this->argument('name'));

        $message = Stub::of($namespace, $name, 'api-trait.stub', ucwords($name).'Api.php');

        $this->components->info($message);
    }
}
