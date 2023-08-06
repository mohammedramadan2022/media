<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\REQUEST_API_PARENT;

class GetDataWithSearchRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'term' => ['nullable', 'string'],
        ];
    }
}
