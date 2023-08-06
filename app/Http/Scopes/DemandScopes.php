<?php

namespace App\Http\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait DemandScopes
{
    public function scopeSearch(Builder $query, $term): Builder
    {
        $query->whereLike('name', $term);

        $query->orWhereLike('email', $term);

        $query->orWhereLike('identity', $term);

        $query->orWhereLike('store_name', $term);

        return $query;
    }
}
