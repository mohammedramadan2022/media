<?php

namespace App\Console\Commands;

use App\Facade\Support\Core\Stub;
use Illuminate\Console\Command;

class MakeVueFileCommand extends Command
{
    protected $signature = 'vue:make {path}';

    protected $description = 'Create Vue js file Command description';

    public function handle(): void
    {
        $path = str($this->argument('path'))->replace('.', ds());

        $full_path = resources_path_normalized('js/components/'.$path.'.vue');

        $message = Stub::createGeneralFileTemplate($full_path, 'vue');

        $this->components->info($message);
    }
}
