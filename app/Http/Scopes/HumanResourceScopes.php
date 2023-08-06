<?php

namespace App\Http\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait HumanResourceScopes
{
    public function scopeSearch(Builder $query, $term): Builder
    {
        $query->join('human_resource_translations as hrt', function ($join) {
            $join->on('hrt.human_resource_id', '=', 'human_resources.id');
            $join->where('hrt.locale', getLocale());
        });

        $query->select(['human_resources.*']);

        $query->whereLike('hrt.title', $term);

        return $query;
    }
}
