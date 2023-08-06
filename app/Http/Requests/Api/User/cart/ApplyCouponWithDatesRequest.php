<?php

namespace App\Http\Requests\Api\User\cart;

use App\Http\Requests\REQUEST_API_PARENT;

class ApplyCouponWithDatesRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'coupon'    => ['nullable', 'string', 'exists:coupons,name'],
            'startDate' => ['required', 'date_format:Y-m-d', 'before:endDate', 'after:' . now()->format('Y-m-d')],
            'endDate'   => ['required', 'date_format:Y-m-d', 'after:startDate'],
        ];
    }
}
