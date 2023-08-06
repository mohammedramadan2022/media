<?php

namespace App\Http\Requests\Api\Employee;

use App\Http\Requests\REQUEST_API_PARENT;

class SetOrderUndertakingRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'order_id' => ['required', 'numeric', 'exists:orders,id'],
            'content'  => ['required', 'string', 'min:1', 'max:255'],
        ];
    }
}
