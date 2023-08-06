<?php

namespace App\Http\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait CourseScopes
{
    public function scopeSearch(Builder $query, $term): Builder
    {
        $query->join('course_translations as ct', function ($join) {
            $join->on('ct.course_id', '=', 'courses.id');
            $join->where('ct.locale', getLocale());
        });

        $query->select(['courses.*']);

        $query->whereLike('ct.title', $term);

        return $query;
    }
}
