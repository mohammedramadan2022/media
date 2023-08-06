<?php

namespace App\Http\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait CityScopes
{
    public function scopeSearch(Builder $query, $term): Builder
    {
        $query->join('city_translations as ct', function (Builder $join) {
            $join->on('ct.city_id', '=', 'cities.id');
            $join->where('ct.locale', getLocale());
        });

        $query->select(['cities.*']);

        $query->where('ct.name', 'LIKE', "%$term%");

        $query->orWhere('cities.address', 'LIKE', "%$term%");

        $query->orWhere('cities.phone', 'LIKE', "%$term%");

        return $query;
    }
}
