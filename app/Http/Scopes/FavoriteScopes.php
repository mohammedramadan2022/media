<?php

namespace App\Http\Scopes;

trait FavoriteScopes
{
    public function scopeSearch($query, $term)
    {
        return $query;
    }
}
