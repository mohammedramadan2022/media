<?php

namespace App\Http\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait SubjectScopes
{
    public function scopeSearch(Builder $query, $term): Builder
    {
        $query->join('subject_translations as st', function ($join) {
            $join->on('st.subject_id', '=', 'subjects.id');
            $join->where('st.locale', getLocale());
        });

        $query->select(['subjects.*']);

        $query->where('st.name', 'LIKE', "%$term%");

        return $query;
    }
}
