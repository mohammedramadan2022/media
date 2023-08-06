<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class CreateCityRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'image'   => ['required', 'mimes:png,jeg,jpeg'],
            'address' => ['required', 'string'],
            'phone'   => ['required', 'numeric'],
            'ar.name' => ['required', 'string', setValidationLang('ar')],
            'en.name' => ['nullable', 'string', setValidationLang('en')],
        ];
    }
}
