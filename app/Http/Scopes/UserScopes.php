<?php

namespace App\Http\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait UserScopes
{
    public function scopeSearch(Builder $query, $term): Builder
    {
        $query->where('name', 'LIKE', "%$term%");

        $query->orWhere('email', 'LIKE', "%$term%");

        $query->orWhere('phone', 'LIKE', "%$term%");

        return $query;
    }
}
