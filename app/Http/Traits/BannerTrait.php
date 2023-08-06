<?php

namespace App\Http\Traits;

use App\Http\Scopes\BannerScopes;

trait BannerTrait
{
    use BasicTrait, BannerScopes;

    public static function types($type = null)
    {
        $types = [
            'section' => trans('back.sections.section'),
            'product' => trans('back.products.product'),
            'link' => trans('back.link'),
            'none' => trans('back.no-link'),
        ];

        return $type ? $types[$type] : $types;
    }

    protected static function boot()
    {
        parent::boot();

        static::forceDeleting(function ($model) {
            storage_unlink('banners', $model->image);
        });
    }
}
