<?php

namespace App\Http\Scopes;

trait ShoppingCartScopes
{
    public function scopeSearch($query, $term)
    {
        return $query;
    }
}
