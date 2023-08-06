<?php

namespace App\Http\Requests\Api\Employee;

use App\Http\Requests\REQUEST_API_PARENT;

class SetDeliveryProviderActionRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        $required = request()->filled('action') && request('action') == 'reject' ? 'required' : 'nullable';

        return [
            'order_id' => ['required', 'numeric', 'exists:orders,id'],
            'action'   => ['required', 'string', 'in:accept,reject'],
            'reason'   => [$required, 'string', 'min:3', 'max:255'],
        ];
    }
}
