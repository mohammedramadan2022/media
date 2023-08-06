<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\REQUEST_API_PARENT;

class GetCitiesByAreaIdRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'area_id' => ['required', 'numeric', 'exists:areas,id'],
        ];
    }
}
