<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class CreateFaqRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'ar.question' => ['required', 'string', setValidationLang('ar')],
            'en.question' => ['nullable', 'string', setValidationLang('en')],
            'ar.answer'   => ['required', 'string', setValidationLang('ar')],
            'en.answer'   => ['nullable', 'string', setValidationLang('en')],
        ];
    }
}
