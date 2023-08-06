<?php

namespace App\Http\Requests\Back;

use App\Rules\EmailFormatChecker;
use App\Rules\PasswordRule;
use Illuminate\Foundation\Http\FormRequest;

class EditAdminProfileRequest extends FormRequest
{
    public function rules(): array
    {
        $admin = auth()->guard('admin')->id();

        return [
            'name'     => ['required', 'string'],
            'email'    => ['required', 'email', new EmailFormatChecker(), 'unique:admins,email,' . $admin],
            'phone'    => ['nullable', 'numeric', 'digits_between:10,10'],
            //            'country_code' => ['required', 'numeric', 'exists:countries,country_code'],
            'password' => ['nullable', 'min:6', new PasswordRule()],
            'image'    => ['nullable', 'image', 'mimes:jpg,png,jpeg,svg', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.digits_between' => trans('api.phone_digits_between', ['num' => 10]),
        ];
    }
}
