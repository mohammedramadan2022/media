<?php

namespace App\Http\Scopes;

trait AddressScopes
{
    public function scopeSearch($query, $term)
    {
        return $query;
    }
}
