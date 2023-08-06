<?php

namespace App\Console\Commands;

use App\Facade\Support\Core\Stub;
use Illuminate\Console\Command;

class MakeInterfaceCommand extends Command
{
    protected $signature = 'make:interface {name}';

    protected $description = 'Make an interface class';

    public function handle(): void
    {
        $namespace = 'App\Repository\Contracts';

        $full_path = 'I'.$this->argument('name').'Repository.php';

        $message = Stub::of($namespace, $this->argument('name'), 'interface.stub', $full_path);

        $this->components->info($message);
    }
}
