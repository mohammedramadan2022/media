<?php

namespace App\Http\Requests\Back;

use App\Rules\EmailFormatChecker;
use Illuminate\Foundation\Http\FormRequest;

class EditAdminRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'    => ['required', 'string'],
            'phone'   => ['required', 'string'],
            'role_id' => ['required', 'numeric', 'exists:roles,id'],
            'email'   => ['required', 'email', new EmailFormatChecker(), 'unique:admins,email,' . $this->admin->id],
            'image'   => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:1000'],
        ];
    }
}
