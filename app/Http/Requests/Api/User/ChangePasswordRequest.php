<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\REQUEST_API_PARENT;
use App\Rules\PasswordRule;

class ChangePasswordRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'old_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:6', new PasswordRule()],
        ];
    }

    public function messages(): array
    {
        return [
            'new_password.min' => trans('api.password-min'),
        ];
    }
}
