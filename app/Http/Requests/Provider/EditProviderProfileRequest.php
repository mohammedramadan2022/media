<?php

namespace App\Http\Requests\Provider;

use App\Rules\EmailFormatChecker;
use Illuminate\Foundation\Http\FormRequest;

class EditProviderProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'       => ['nullable', 'string', 'min:3', 'max:50'],
            'email'      => ['nullable', 'email', new EmailFormatChecker()],
            'identity'   => ['nullable', 'numeric'],
            'phone'      => ['nullable', 'numeric'],
            'address'    => ['nullable', 'string'],
            'store_name' => ['nullable', 'string', 'min:3', 'max:100'],
            'logo'       => ['nullable', 'mimes:png,jpeg,jpg'],
            'password'   => ['nullable', 'string', 'min:3'],
        ];
    }
}
