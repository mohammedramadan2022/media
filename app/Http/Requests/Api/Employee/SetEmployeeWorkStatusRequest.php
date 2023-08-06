<?php

namespace App\Http\Requests\Api\Employee;

use App\Http\Requests\REQUEST_API_PARENT;

class SetEmployeeWorkStatusRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'status' => ['required', 'string', 'in:active,deductive'],
        ];
    }
}
