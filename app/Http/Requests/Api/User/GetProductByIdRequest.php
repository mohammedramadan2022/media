<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\REQUEST_API_PARENT;

class GetProductByIdRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'numeric', 'exists:products,id,status,"1"'],
        ];
    }
}
