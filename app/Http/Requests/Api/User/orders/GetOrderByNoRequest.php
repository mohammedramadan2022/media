<?php

namespace App\Http\Requests\Api\User\orders;

use App\Http\Requests\REQUEST_API_PARENT;

class GetOrderByNoRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'order_no' => ['required', 'numeric', 'exists:orders,order_no'],
        ];
    }
}
