<?php

namespace App\Http\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait SectionScopes
{
    public function scopeSearch(Builder $query, $term): Builder
    {
        $query->join('section_translations as st', function (Builder $join) {
            $join->on('st.section_id', '=', 'sections.id');
            $join->where('st.locale', getLocale());
        });

        $query->select(['sections.*']);

        $query->where('st.name', 'LIKE', "%$term%");

        return $query;
    }
}
