<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class EditSectionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'icon'    => ['required', 'string'],
            'ar.name' => ['required', 'string', setValidationLang('ar')],
            'en.name' => ['required', 'string', setValidationLang('en')],
        ];
    }
}
