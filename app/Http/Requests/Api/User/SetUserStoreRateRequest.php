<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\REQUEST_API_PARENT;

class SetUserStoreRateRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'store_id' => ['required', 'numeric', 'exists:providers,id'],
            'name'     => ['required', 'string', 'min:3', 'max:100'],
            'comment'  => ['nullable', 'string', 'min:3', 'max:255'],
            'rate'     => ['required', 'numeric', 'in:1,2,3,4,5'],
        ];
    }
}
