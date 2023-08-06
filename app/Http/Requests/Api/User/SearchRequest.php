<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\REQUEST_API_PARENT;

class SearchRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'term'         => ['nullable', 'string'],
            'sort_by_rate' => ['nullable', 'string', 'in:desc,asc'],
            'page'         => ['nullable', 'numeric'],
            'area_id'      => ['nullable', 'numeric', 'exists:areas,id,status,"1"'],
            'city_id'      => ['nullable', 'numeric', 'exists:cities,id,status,"1"'],
        ];
    }
}
