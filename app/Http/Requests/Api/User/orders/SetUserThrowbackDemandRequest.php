<?php

namespace App\Http\Requests\Api\User\orders;

use App\Http\Requests\REQUEST_API_PARENT;

class SetUserThrowbackDemandRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'order_id' => ['required', 'numeric', 'exists:orders,id'],
            'reason'   => ['required', 'string'],
        ];
    }
}
