<?php

namespace App\Providers;

use App\Facade\Support\Tools\Directory;
use App\Repository\Contracts;
use App\Repository\Eloquent\Sql\BaseRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $support = 'App\Facade\Support';

        $repo = "App\Repository";

        foreach (Directory::models() as $model) {
            $interface = $repo."\Contracts\I{$model}Repository";

            $implementation = $repo."\Eloquent\Sql\\{$model}Repository";

            $this->app->bind(abstract: $interface, concrete: $implementation);
        }

        $this->app->bind(Contracts\IEloquentRepository::class, BaseRepository::class);

        $this->app->bind(Contracts\IFormIcons::class, $support.'\Icons\\'.self::setConcrete(config('icons.file')));

        $this->app->bind(Contracts\SmsInterface::class, $support.'\Sms\\'.self::setConcrete(config('sms.sms_provider')));

        $this->app->bind(Contracts\PayInterface::class, $support.'\Pay\\'.self::setConcrete(config('pay.service_name')));
    }

    public function boot()
    {
        //
    }

    private static function setConcrete($name): string
    {
        return (string) str($name)->camel()->headline();
    }
}
