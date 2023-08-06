<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\REQUEST_API_PARENT;
use App\Rules\MapUrlRule;
use App\Rules\MobilePhoneRule;

class UpdateUserAddressRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'address_id'     => ['required', 'numeric', 'exists:addresses,id'],
            'city_id'        => ['required', 'numeric', 'exists:cities,id'],
            'recipient_name' => ['nullable', 'string', 'min:3', 'max:50'],
            'special_marque' => ['nullable', 'string', 'min:3', 'max:50'],
            'street'         => ['nullable', 'string', 'min:3', 'max:50'],
            'phone'          => ['nullable', 'numeric', new MobilePhoneRule()],
            'map_url'        => ['required', 'active_url', new MapUrlRule()],
        ];
    }
}
