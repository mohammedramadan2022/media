<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\REQUEST_API_PARENT;
use App\Rules\MapUrlRule;
use App\Rules\MobilePhoneRule;

class AddNewAddressRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'recipient_name' => ['required', 'string', 'min:3'],
            'street'         => ['required', 'string', 'min:3'],
            'phone'          => ['required', 'numeric', new MobilePhoneRule()],
            'city_id'        => ['required', 'numeric', 'exists:cities,id'],
            'special_marque' => ['required', 'string'],
            'map_url'        => ['required', 'active_url', new MapUrlRule()],
        ];
    }
}
