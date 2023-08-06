<?php

namespace App\Http\Requests\Api\Employee;

use App\Enums\OrderStatus;
use App\Http\Requests\REQUEST_API_PARENT;
use Illuminate\Validation\Rule;

class SetEmployeeOrderActionRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        $cancel = [OrderStatus::CANCELED, OrderStatus::REJECTED_FROM_WAREHOUSE];

        $required = request()->filled('action') && in_array(request('action'), $cancel);

        return [
            'order_id' => ['required', 'numeric', 'exists:orders,id'],
            'action'   => [
                'required',
                'string',
                Rule::in([
                    OrderStatus::ACCEPTED,
                    OrderStatus::PROCESSED,
                    OrderStatus::PROCESSING,
                    OrderStatus::READY_FOR_DELIVERY,
                    OrderStatus::REJECTED_FROM_WAREHOUSE,
                    OrderStatus::DELIVERED_TO_MERCHANT,
                    OrderStatus::DELIVERY_TO_WAREHOUSE,
                    OrderStatus::REVIEWED,
                    OrderStatus::RECEIVED,
                    OrderStatus::IN_DELIVERY,
                    OrderStatus::RETRIEVING,
                    OrderStatus::DELIVERED,
                    OrderStatus::NOT_RECEIVED,
                    OrderStatus::CANCELED,
                ]),
            ],
            'reason'   => [$required, 'string', 'min:3', 'max:255'],
        ];
    }
}
