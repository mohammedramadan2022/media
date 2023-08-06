<?php

namespace App\Http\Requests\Api\User\orders;

use App\Http\Requests\REQUEST_API_PARENT;

class GetOrderByIdRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'order_id' => ['required', 'numeric', 'exists:orders,id'],
        ];
    }
}
