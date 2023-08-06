<?php

namespace App\Http\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait PaymentScopes
{
    public function scopeSearch(Builder $query, $term): Builder
    {
        $query->join('users', 'users.id', '=', 'payments.user_id');

        $query->select(['payments.*']);

        $query->where('payments.amount', 'LIKE', "%$term%");

        $query->orWhere('users.first_name', 'LIKE', "%$term%");

        $query->orWhere('users.last_name', 'LIKE', "%$term%");

        return $query;
    }
}
