<?php

namespace App\Http\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait UndertakingScopes
{
    public function scopeSearch(Builder $query, $term): Builder
    {
        return $query;
    }
}
