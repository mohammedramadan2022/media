<?php

namespace App\Http\Requests\Back;

use App\Rules\EmailFormatChecker;
use App\Rules\PasswordRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateAdminRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'     => ['required', 'string'],
            'phone'    => ['required', 'string'],
            'role_id'  => ['required', 'numeric', 'exists:roles,id'],
            'email'    => ['required', 'email', new EmailFormatChecker(), 'unique:admins,email'],
            'password' => ['required', 'confirmed', 'min:6', new PasswordRule()],
            'image'    => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:2048'],
        ];
    }
}
