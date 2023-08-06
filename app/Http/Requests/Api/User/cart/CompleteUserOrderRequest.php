<?php

namespace App\Http\Requests\Api\User\cart;

use App\Http\Requests\REQUEST_API_PARENT;
use App\Rules\{CheckEndDateRule, CheckStartTimeRule, CheckStartDateRule};

class CompleteUserOrderRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'is_applied'    => ['nullable'],
            'address_id'    => ['required', 'numeric', 'exists:addresses,id'],
            'coupon'        => ['nullable', 'string', 'exists:coupons,name'],
            'startDate'     => ['required', 'date_format:Y-m-d', new CheckStartDateRule()],
            'startTime'     => ['required', 'date_format:H:i', new CheckStartTimeRule()],
            'endDate'       => ['required', 'date_format:Y-m-d', new CheckEndDateRule()],
            'type'          => ['required', 'in:hour,day'],
        ];
    }
}
