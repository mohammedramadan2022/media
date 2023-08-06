<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\REQUEST_API_PARENT;

class ResetPasswordRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'email'    => ['required', 'email', 'exists:users,email'],
            'code'     => ['required', 'string', 'max:4', 'min:4'],
            'password' => ['required', 'string'],
        ];
    }
}
