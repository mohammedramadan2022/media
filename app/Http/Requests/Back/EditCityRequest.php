<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class EditCityRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'image'   => ['nullable', 'mimes:png,jeg,jpeg'],
            'address' => ['required', 'string'],
            'phone'   => ['required', 'numeric'],
            'ar.name' => ['required', 'string', setValidationLang('ar')],
            'en.name' => ['required', 'string', setValidationLang('en')],
        ];
    }
}
