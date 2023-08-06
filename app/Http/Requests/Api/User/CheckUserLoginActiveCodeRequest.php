<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\REQUEST_API_PARENT;

class CheckUserLoginActiveCodeRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'username' => ['required', 'string'],
            'code'     => ['required', 'numeric'],
        ];
    }
}
