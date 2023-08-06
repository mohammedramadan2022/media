<?php

namespace App\Console\Commands;

use App\Facade\Support\Tools\Directory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DropDatabaseTableCommand extends Command
{
    protected $signature = 'drop:table {model}';

    protected $description = 'Drop Database Table with migration Command description';

    public function handle(): void
    {
        $model = plural($this->argument('model'))->lower()->value();

        DB::table('migrations')->where('migration','LIKE',"%$model%")->delete();

        File::delete(Directory::migrations($model));

        $this->components->info('Table deleted successfully');
    }
}
