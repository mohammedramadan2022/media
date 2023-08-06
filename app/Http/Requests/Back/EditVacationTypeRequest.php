<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class EditVacationTypeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'ar.name' => ['required', 'string', 'min:3', setValidationLang('ar')],
            'en.name' => ['nullable', 'string', 'min:3', setValidationLang('en')],
        ];
    }
}
