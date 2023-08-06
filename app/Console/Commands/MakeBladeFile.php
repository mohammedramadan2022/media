<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeBladeFile extends Command
{
    protected $signature = 'make:blade {model}';

    protected $description = 'Make a blade file';

    public function handle(): void
    {
        $plural = plural($this->argument('model'))->ucfirst();

        File::ensureDirectoryExists(base_path(normalizePath('resources/views/Back/').$plural), 0777);

        $this->copy_file($plural, 'index');

        $this->copy_file($plural, 'form');

        $this->copy_file($plural, 'trashed');

        $this->components->info('Blade Files Created Successfully');
    }

    private function copy_file($plural, $type): void
    {
        copy(self::getDefaultFiles($type), views_path(normalizePath('Back/'.$plural.'/'.$type.'.blade.php')));
    }

    private function getDefaultFiles($type): string
    {
        return normalizePath(views_path('Back/Crud/'.$type.'.blade.php'));
    }
}
