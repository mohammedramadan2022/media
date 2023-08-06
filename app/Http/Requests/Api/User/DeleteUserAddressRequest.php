<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\REQUEST_API_PARENT;

class DeleteUserAddressRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'address_id' => ['required', 'numeric', 'exists:addresses,id'],
        ];
    }
}
