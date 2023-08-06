<?php

namespace App\Http\Requests\Api\Employee;

use App\Http\Requests\REQUEST_API_PARENT;
use App\Rules\EmailFormatChecker;

class AdminLoginRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'role_id'      => ['required', 'exists:roles,id'],
            'email'        => ['required', 'email', new EmailFormatChecker()],
            'password'     => ['required', 'string'],
            'device_token' => ['nullable', 'string'],
        ];
    }
}
