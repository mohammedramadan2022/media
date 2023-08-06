<?php

namespace App\Providers;

use App\Facade\mixins;
use App\Facade\Support\Tools\CrudTranslation;
use App\Http\Traits\Callbacks\AppCallbacks;
use Carbon\Carbon;
use Illuminate\Database\Eloquent;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use ReflectionException;

class MacroServiceProvider extends ServiceProvider
{
    use AppCallbacks;

    public function register()
    {
        //
    }

    /*** @throws ReflectionException */
    public function boot(): void
    {
        Route::macro('crud', fn ($table, $controller, $withShow = true, $callback = null) => CrudTranslation::trans($table, $controller, $withShow, $callback));

        Collection::macro('paginate', function ($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage($pageName);

            return new \Illuminate\Pagination\LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });

        Carbon::mixin(new mixins\CarbonMixin());

        Eloquent\Collection::mixin(new mixins\CollectionMixin());

        Eloquent\Builder::mixin(new mixins\BuilderMixin());

        Str::mixin(new mixins\StrMixin());

        Stringable::mixin(new mixins\StringableMixin());
    }
}
