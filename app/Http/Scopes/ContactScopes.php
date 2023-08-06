<?php

namespace App\Http\Scopes;

trait ContactScopes
{
    public function scopeSearch($query, $term)
    {
        $query->where('name', 'LIKE', "%$term%");

        $query->orWhere('email', 'LIKE', "%$term%");

        $query->orWhere('subject', 'LIKE', "%$term%");

        $query->orWhere('message', 'LIKE', "%$term%");

        return $query;
    }
}
