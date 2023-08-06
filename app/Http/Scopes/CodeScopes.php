<?php

namespace App\Http\Scopes;

trait CodeScopes
{
    public function scopeWhenPhoneAndCodeIs($query, $request)
    {
        return $query->where(['type' => $request->type, 'value' => $request->value]);
    }

    public function scopeWhenTypeAndValue($query, $value)
    {
        $query->where(function ($q) {
            $q->where('type', 'phone');
            $q->orWhere('type', 'email');
        });

        $query->where('value', $value);

        return $query;
    }
}
