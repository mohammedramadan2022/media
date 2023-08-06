<?php

namespace App\Http\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait CategoryScopes
{
    public function scopeSearch(Builder $query, $term): Builder
    {
        $query->join('category_translations as ct', function ($join) {
            $join->on('ct.category_id', '=', 'categories.id');
            $join->where('ct.locale', getLocale());
        });

        $query->join('section_translations as st', function ($join) {
            $join->on('st.section_id', '=', 'categories.section_id');
            $join->where('st.locale', getLocale());
        });

        $query->select(['categories.*']);

        $query->where('ct.name', 'LIKE', "%$term%");

        $query->orWhere('st.name', 'LIKE', "%$term%");

        return $query;
    }
}
