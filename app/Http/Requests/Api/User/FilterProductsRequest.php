<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\REQUEST_API_PARENT;

class FilterProductsRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'store_id'    => ['nullable', 'numeric', 'exists:providers,id'],
            'city_id'     => ['nullable', 'numeric', 'exists:cities,id'],
            'section_id'  => ['nullable', 'numeric', 'exists:sections,id'],
            'category_id' => ['nullable', 'numeric', 'exists:categories,id'],
            'term'        => ['nullable', 'string', 'min:1', 'max:255'],
            'sort_by'     => ['nullable', 'in:price_low_high,price_high_low,rate,recently'],
            'type'        => ['nullable', 'in:stores,general'],
            'startDate'   => ['nullable'],
            'endDate'     => ['nullable'],
            'has_offer'   => ['nullable', 'boolean'],
        ];
    }
}
