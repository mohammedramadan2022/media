<?php

namespace App\Http\Traits;

use App\Http\Scopes\FeatureScopes;

trait FeatureTrait
{
    use BasicTrait, FeatureScopes;

    protected static function boot(): void
    {
        parent::boot();

        static::forceDeleting(function ($model) {
            storage_unlink('features', $model->image);
        });
    }
}
