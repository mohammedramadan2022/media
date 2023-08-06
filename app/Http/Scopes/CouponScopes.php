<?php

namespace App\Http\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait CouponScopes
{
    public function scopeSearch(Builder $query, $term): Builder
    {
        $query->where('name', 'LIKE', "%$term%");

        return $query;
    }
}
