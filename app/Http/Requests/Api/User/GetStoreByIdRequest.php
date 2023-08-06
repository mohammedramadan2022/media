<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\REQUEST_API_PARENT;

class GetStoreByIdRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'store_id' => ['required', 'numeric', 'exists:providers,id'],
            'sort_by'  => ['nullable', 'in:price_high_low,price_low_high,recently,rate'],
        ];
    }
}
