<?php

namespace App\Http\Scopes;

trait PreviewScopes
{
    public function scopeSearch($query, $term)
    {
        return $query;
    }
}
