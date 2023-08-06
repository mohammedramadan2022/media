<?php

namespace App\Http\Requests\Api\Employee;

use App\Http\Requests\REQUEST_API_PARENT;

class EmployeeSearchRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'term' => ['required', 'string', 'min:1', 'max:255'],
        ];
    }
}
