<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\REQUEST_API_PARENT;
use App\Rules\EmailFormatChecker;

class UserLoginRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'email'        => ['required', 'email:filter', new EmailFormatChecker()],
            'password'     => ['required', 'string'],
            'device_token' => ['nullable', 'string'],
        ];
    }
}
