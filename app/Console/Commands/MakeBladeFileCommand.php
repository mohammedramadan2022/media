<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeBladeFileCommand extends Command
{
    protected $signature = 'make:blade-file {path}';

    protected $description = 'Create new empty blade file';

    public function handle(): void
    {
        $folders = explode('.', $this->argument('path'));

        $file_index = array_key_last($folders);

        $path = views_path(implode(ds(), except($folders, $file_index)));

        $file_path = $path.ds().$folders[$file_index].'.blade.php';

        File::ensureDirectoryExists($path, 0777);

        if (File::exists($file_path)) {
            $this->components->error('File Already Exists !!');

            return;
        }

        File::put($file_path, '');

        $this->components->info('Blade File Created Successfully');
    }
}
