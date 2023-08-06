<?php

namespace App\Http\Requests\Api\User\cart;

use App\Http\Requests\REQUEST_API_PARENT;

class RemoveProductFromCartRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'numeric', 'exists:products,id'],
            'cart_id'    => ['nullable', 'numeric', 'exists:carts,id'],
        ];
    }
}
