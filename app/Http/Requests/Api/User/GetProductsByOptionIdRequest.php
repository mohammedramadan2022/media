<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\REQUEST_API_PARENT;

class GetProductsByOptionIdRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'options'     => ['nullable', 'array'],
            'options.*'   => ['required', 'numeric'],
            'category_id' => ['required', 'numeric', 'exists:categories,id'],
            'belongs_to'  => ['required', 'in:rental,store'],
        ];
    }
}
