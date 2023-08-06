<?php

namespace App\Http\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait BasicScopes
{
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 1);
    }

    public function scopeWhenIdIs(Builder $query, $id): Builder
    {
        return $query->where('status', 1)->where('id', $id);
    }

    public function scopeWithHas($query, $relation)
    {
        return $query->has($relation)->with($relation, $relation.'.translation');
    }
}
