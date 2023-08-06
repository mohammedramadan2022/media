<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class CreateSubjectRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'ar.name' => ['required', 'string', setValidationLang('ar')],
            'en.name' => ['nullable', 'string', setValidationLang('en')],
        ];
    }
}
