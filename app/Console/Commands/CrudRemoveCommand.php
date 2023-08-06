<?php

namespace App\Console\Commands;

use App\Facade\Support\Tools\Directory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class CrudRemoveCommand extends Command
{
    protected $signature = 'crud:remove {model : the model name}
        {--T|translatable : this flag is optional}';

    protected $description = 'Remove Full Crud Command';

    public function handle(): void
    {
        $model = ucwords($this->argument('model'));

        if ($this->option('translatable')) File::delete(app_path('/Models/'.$model.'Translation.php'));

        File::delete(app_path('Models/'.$model.'.php'));
        File::delete(migrations_path('/'.Directory::migration(lower($model))));
        File::delete(app_path('Http/Traits/'.$model.'Trait.php'));
        File::delete(app_path('Http/Traits/Api/'.$model.'Api.php'));
        File::delete(app_path('Http/Scopes/'.$model.'Scopes.php'));
        File::delete(app_path('Http/Controllers/Back/'.$model.'Controller.php'));
        File::delete(app_path('Http/Requests/Back/Create'.$model.'Request.php'));
        File::delete(app_path('Http/Requests/Back/Edit'.$model.'Request.php'));
        File::delete(app_path('Http/Resources/'.$model.'Resource.php'));
        File::delete(app_path('Repository/Contracts/I'.$model.'Repository.php'));
        File::delete(app_path('Repository/Eloquent/Sql/'.$model.'Repository.php'));
        File::deleteDirectory(resource_path('/views/Back/'.ucwords(plural($model))));

        Schema::dropIfExists(plural($model));

        DB::table('migrations')->where('migration','LIKE','%'.Directory::migration(lower($model)).'%')->delete();

        $this->components->info('The Crud removed successfully');
    }
}
