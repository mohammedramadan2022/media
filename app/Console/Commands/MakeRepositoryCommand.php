<?php

namespace App\Console\Commands;

use App\Facade\Support\Core\Stub;
use Illuminate\Console\Command;

class MakeRepositoryCommand extends Command
{
    protected $signature = 'make:repository {name}';

    protected $description = 'Make an repository class';

    public function handle(): void
    {
        $namespace = 'App\Repository\Eloquent\Sql';

        $name = $this->argument('name');

        $mess = Stub::of($namespace, $name, 'repository.stub', $name.'Repository.php');

        $this->components->info($mess);
    }
}
