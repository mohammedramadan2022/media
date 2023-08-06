<?php

namespace App\Http\Requests\Api\User\orders;

use App\Enums\OrderStatus;
use App\Http\Requests\REQUEST_API_PARENT;
use Illuminate\Validation\Rule;

class FilterUserOrdersRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        $status = [
            OrderStatus::ALL,
            OrderStatus::PENDING,
            OrderStatus::ACCEPTED,
            OrderStatus::PROCESSING,
            OrderStatus::REJECTED,
            OrderStatus::DELIVERED,
            OrderStatus::PROCESSED,
            OrderStatus::DELIVERED,
            OrderStatus::RETRIEVING,
            OrderStatus::IN_DELIVERY,
        ];

        return [
            'filter' => ['required', 'string', Rule::in($status)],
            'term'   => ['nullable', 'string', 'min:1'],
        ];
    }
}
