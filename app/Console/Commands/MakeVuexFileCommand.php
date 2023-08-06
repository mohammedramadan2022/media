<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeVuexFileCommand extends Command
{
    protected $signature = 'vuex:make {module}';

    protected $description = 'Create Vue js Module file Command description';

    public function handle(): void
    {
        $name = Str::lower($this->argument('model'));

        $file_path = resource_path('/js/store/modules/'.$name.'/index.js');

        File::ensureDirectoryExists(dirname($file_path));

        if (File::exists($file_path)) {
            $this->components->error('File Already Exists');

            return;
        }

        File::put($file_path, file_get_contents(stubs_path('/vuex.stub')));

        $this->components->info('File created successfully');
    }
}
