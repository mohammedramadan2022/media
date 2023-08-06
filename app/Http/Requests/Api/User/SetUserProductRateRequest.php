<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\REQUEST_API_PARENT;

class SetUserProductRateRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'numeric', 'exists:products,id'],
            'name'       => ['required', 'string', 'min:3', 'max:100'],
            'comment'    => ['nullable', 'string', 'min:3', 'max:255'],
            'rate'       => ['required', 'numeric', 'in:1,2,3,4,5'],
        ];
    }
}
