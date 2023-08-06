<?php

namespace App\Http\Requests\Api\User\orders;

use App\Http\Requests\REQUEST_API_PARENT;

class ChangeUserOrderAddressRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        $required = request('delivery_type') == 'address' ? 'required' : 'nullable';

        return [
            'order_id'      => ['required', 'numeric', 'exists:orders,id'],
            'address_id'    => [$required, 'numeric', 'exists:addresses,id'],
            'delivery_type' => ['required', 'string', 'in:location,address'],
        ];
    }
}
