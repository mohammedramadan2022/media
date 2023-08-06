<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class CreateRoleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'permissions.0' => ['required'],
            'ar.name'       => ['required', 'string', setValidationLang('ar')],
            'en.name'       => ['nullable', 'string', setValidationLang('en')],
        ];
    }
}
