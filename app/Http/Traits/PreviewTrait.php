<?php

namespace App\Http\Traits;

use App\Http\Scopes\PreviewScopes;
use App\Http\Traits\Api\PreviewApi;

trait PreviewTrait
{
    use BasicTrait, PreviewScopes, PreviewApi;

    protected static function boot(): void
    {
        parent::boot();

        static::deleting(function ($model) {
            storage_unlink('previews', $model->image);
        });
    }
}
