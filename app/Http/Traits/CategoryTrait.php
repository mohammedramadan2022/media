<?php

namespace App\Http\Traits;

use App\Facade\Support\Core\Crud;
use App\Http\Scopes\CategoryScopes;
use App\Http\Traits\Api\CategoryApi;
use App\Models\Category;

trait CategoryTrait
{
    use BasicTrait, CategoryScopes, CategoryApi;

    public static function getInSelectForm(): array
    {
        return Crud::getModelsInSelectedForm(Category::class);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::forceDeleting(fn ($model) => storage_unlink('categories', $model->image));
    }
}
