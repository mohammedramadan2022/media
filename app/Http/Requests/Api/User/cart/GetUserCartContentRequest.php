<?php

namespace App\Http\Requests\Api\User\cart;

use App\Http\Requests\REQUEST_API_PARENT;

class GetUserCartContentRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'cart_id' => ['required', 'numeric', 'exists:carts,id'],
        ];
    }
}
