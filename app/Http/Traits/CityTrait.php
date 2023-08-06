<?php

namespace App\Http\Traits;

use App\Facade\Support\Core\Crud;
use App\Http\Scopes\CityScopes;
use App\Http\Traits\Api\CityApi;
use App\Models\City;

trait CityTrait
{
    use BasicTrait, CityScopes, CityApi;

    public static function getInSelectForm(): array
    {
        return Crud::getModelsInSelectedForm(model: City::class, withRelations: ['translations']);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::forceDeleting(function ($model) {
            storage_unlink('cities', $model->image);
        });
    }
}
