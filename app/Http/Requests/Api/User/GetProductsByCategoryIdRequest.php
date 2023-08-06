<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\REQUEST_API_PARENT;

class GetProductsByCategoryIdRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'page'        => ['nullable', 'numeric'],
            'store_id'    => ['nullable', 'numeric', 'exists:providers,id'],
            'category_id' => ['required', 'numeric', 'exists:categories,id'],
        ];
    }
}
