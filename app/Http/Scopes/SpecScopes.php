<?php

namespace App\Http\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait SpecScopes
{
    public function scopeSearch(Builder $query, $term): Builder
    {
        return $query;
    }
}
