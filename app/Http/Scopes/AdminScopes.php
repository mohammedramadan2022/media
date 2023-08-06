<?php

namespace App\Http\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait AdminScopes
{
    public function scopeSearch(Builder $query, string $term): Builder
    {
        $query->where('role_id', '!=', 1)->where('name', 'LIKE', "%$term%");

        $query->orWhere('email', 'LIKE', "%$term%");

        $query->orWhere('phone', 'LIKE', "%$term%");

        return $query;
    }

    public function scopeNotSuperAdmin(Builder $query): Builder
    {
        return $query->where('role_id', '!=', 1);
    }
}
