<?php

namespace App\Http\Scopes;

trait FeatureScopes
{
    public function scopeSearch($query, $term)
    {
        return $query;
    }
}
