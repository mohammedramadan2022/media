<?php

namespace App\Http\Requests\Back;

use App\Rules\EmailFormatChecker;
use App\Rules\PasswordRule;
use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'min:3', 'max:255'],
            'last_name'  => ['required', 'string', 'min:3', 'max:255'],
            'phone'      => ['required', 'numeric', 'unique:users,phone,' . $this->user->id],
            'email'      => ['required', 'email', new EmailFormatChecker(), 'unique:users,email,' . $this->user->id],
            'password'   => ['nullable', 'confirmed', 'min:6', new PasswordRule()],
            'image'      => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:2048'],
        ];
    }
}
