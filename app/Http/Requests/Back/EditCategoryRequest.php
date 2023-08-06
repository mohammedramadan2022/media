<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class EditCategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'section_id' => ['required', 'numeric', 'exists:sections,id'],
            'ar.name'    => ['required', 'string', setValidationLang('ar')],
            'en.name'    => ['nullable', 'string', setValidationLang('en')],
            'specs'      => ['nullable', 'array'],
            'specs.*'    => ['nullable', 'numeric', 'exists:specs,id'],
        ];
    }
}
