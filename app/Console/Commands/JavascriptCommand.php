<?php

namespace App\Console\Commands;

use App\Facade\Support\Core\Stub;
use Illuminate\Console\Command;

class JavascriptCommand extends Command
{
    protected $signature = 'js:store {name}';

    protected $description = 'Javascript vuex store file Command description';

    public function handle()
    {
        $name = lower($this->argument('name'));

        $filepath = resources_path_normalized('js/store/modules/'.$name.'/index.js');

        $message = Stub::createGeneralFileTemplate($filepath, 'javascript');

        $this->components->info($message);
    }
}
