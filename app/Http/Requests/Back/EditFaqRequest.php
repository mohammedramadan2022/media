<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class EditFaqRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'ar.question' => ['required', 'string', setValidationLang('ar')],
            'en.question' => ['required', 'string', setValidationLang('en')],
            'ar.answer'   => ['required', 'string', setValidationLang('ar')],
            'en.answer'   => ['required', 'string', setValidationLang('en')],
        ];
    }
}
