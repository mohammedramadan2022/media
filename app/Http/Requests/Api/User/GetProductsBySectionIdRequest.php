<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\REQUEST_API_PARENT;

class GetProductsBySectionIdRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'store_id'   => ['nullable', 'numeric', 'exists:providers,id'],
            'section_id' => ['required', 'numeric', 'exists:sections,id,status,"1"'],
        ];
    }
}
