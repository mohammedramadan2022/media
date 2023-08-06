<?php

namespace App\Http\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait RoleScopes
{
    public function scopeSearch(Builder $query, $term): Builder
    {
        $query->join('role_translations as rt', function ($join) {
            $join->on('rt.role_id', '=', 'roles.id');
            $join->where('rt.locale', getLocale());
            $join->where('rt.role_id', '!=', 1);
        });

        $query->select(['roles.*']);

        $query->where('roles.id', '!=', 1);

        $query->orWhere('rt.name', 'LIKE', "%$term%");

        return $query;
    }
}
