<?php

namespace App\Http\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait VacationTypeScopes
{
    public function scopeSearch(Builder $query, $term): Builder
    {
        $query->join('vacation_type_translations as tyt', function ($join) {
            $join->on('tyt.vacation_type_id', '=', 'vacations.id');
            $join->where('tyt.locale', getLocale());
        });

        $query->select(['vacations.*']);

        $query->whereLike('tyt.name', $term);

        return $query;
    }
}
