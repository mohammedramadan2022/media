<?php

namespace App\Http\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait ProviderScopes
{
    public function scopeSearch(Builder $query, $term): Builder
    {
        $query->where('name', 'LIKE', "%$term%");

        $query->orWhere('identity', 'LIKE', "%$term%");

        $query->orWhere('email', 'LIKE', "%$term%");

        return $query;
    }
}
