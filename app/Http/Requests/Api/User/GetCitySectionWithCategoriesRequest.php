<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\REQUEST_API_PARENT;

class GetCitySectionWithCategoriesRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'city_id' => ['required', 'numeric', 'exists:cities,id'],
        ];
    }
}
