<?php

namespace App\Providers;

use App\Http\Traits\Callbacks\AppCallbacks;
use App\Models\{Admin, User};
use App\Observers\{AdminObserver, UserObserver};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\{Blade, View, Schema};
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    use AppCallbacks;

    public function register(): void
    {
        View::composer('*', self::getAuth());

        View::composer('Back.layouts.partials.sidebar', self::getNewMessages());
        View::composer('Back.layouts.partials.sidebar', self::getNewNotifications());
        View::composer('Back.layouts.partials.sidebar', self::getNewProducts());
        View::composer('Back.layouts.partials.sidebar', self::getNewDemands());
        View::composer('Back.layouts.partials.sidebar', self::getNewOrders());
        View::composer('Back.layouts.partials.sidebar', self::getNewVacations());
        View::composer('Back.layouts.partials.sidebar', self::getNewAdvances());
        View::composer('Back.layouts.partials.sidebar', self::getNewThrowbacks());
    }

    public function boot(): void
    {
        View::composer('*', fn ($view) => $view->with('getAllRoutes', getAllRoutes()));

        Blade::if('hasPermission', fn ($route) => permission_route_checker($route));

        Blade::directive('datetime', fn ($expression) => "<?php echo ($expression)->format('m/d/Y H:i'); ?>");

        Schema::enableForeignKeyConstraints();

        Model::preventLazyLoading(! $this->app->isProduction());

        Model::unguard();

        Paginator::useBootstrap();

        User::observe(UserObserver::class);

        Admin::observe(AdminObserver::class);
    }
}
