<?php

namespace App\Http\Requests\Back;

use App\Rules\EmailFormatChecker;
use App\Rules\PasswordRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'min:3', 'max:255'],
            'last_name'  => ['required', 'string', 'min:3', 'max:255'],
            'phone'      => ['required', 'numeric', 'unique:users,phone'],
            'email'      => ['required', 'email', new EmailFormatChecker(), 'unique:users,email'],
            'password'   => ['required', 'confirmed', 'min:6', new PasswordRule()],
            'image'      => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:2048'],
        ];
    }
}
