<?php

namespace App\Http\Requests\Api\User\orders;

use App\Http\Requests\REQUEST_API_PARENT;

class ChangeUserOrderDatesRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'order_id'  => ['required', 'numeric', 'exists:orders,id'],
            'startDate' => ['required', 'date_format:Y-m-d'],
            'startTime' => ['required', 'date_format:H:i'],
            'endDate'   => ['required', 'date_format:Y-m-d', 'after:startDate'],
            'endTime'   => ['required', 'date_format:H:i'],
        ];
    }
}
