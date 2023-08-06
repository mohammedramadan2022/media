<?php

namespace App\Console\Commands;

use App\Facade\Support\Core\Stub;
use Illuminate\Console\Command;

class MakeScopeCommand extends Command
{
    protected $signature = 'make:scope {name}';

    protected $description = 'Make an Scope Trait file';

    public function handle(): void
    {
        $namespace = 'App\Http\Scopes';

        $model = $this->argument('name');

        $message = Stub::of($namespace, $model, 'scope.stub', $model.'Scopes.php');

        $this->components->info($message);
    }
}
