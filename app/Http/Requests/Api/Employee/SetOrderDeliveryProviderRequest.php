<?php

namespace App\Http\Requests\Api\Employee;

use App\Http\Requests\REQUEST_API_PARENT;

class SetOrderDeliveryProviderRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'order_id'    => ['required', 'numeric', 'exists:orders,id'],
            'provider_id' => ['required', 'numeric', 'exists:admins,id'],
        ];
    }
}
