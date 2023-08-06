<?php

namespace App\Http\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait FaqScopes
{
    public function scopeSearch(Builder $query, $term): Builder
    {
        $query->join('faq_translations as ft', function (Builder $join) {
            $join->on('faqs.id', '=', 'ft.faq_id');
            $join->where('locale', getLocale());
        });

        $query->select(['faqs.*']);

        $query->where('ft.question', 'LIKE', "%$term%");

        $query->orWhere('ft.answer', 'LIKE', "%$term%");

        return $query;
    }
}
