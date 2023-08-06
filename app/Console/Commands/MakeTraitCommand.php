<?php

namespace App\Console\Commands;

use App\Facade\Support\Core\Stub;
use Illuminate\Console\Command;

class MakeTraitCommand extends Command
{
    protected $signature = 'make:trait {name}';

    protected $description = 'Make an Trait file';

    public function handle(): void
    {
        $namespace = 'App\Http\Traits';

        $name = $this->argument('name');

        $message = Stub::of($namespace, $name, 'trait.stub', $name.'Trait.php');

        $this->components->info($message);
    }
}
