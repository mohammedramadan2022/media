<?php

namespace App\Http\Requests\Back;

use App\Models\Spec;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateSpecRequest extends FormRequest
{
    public function rules(): array
    {
        $required = request('type') == 'select' ? 'required' : 'nullable';

        $required_color = request('dropdown') == 'color' ? 'required' : 'nullable';

        return [
            'ar.name'    => ['required', 'string', setValidationLang('ar')],
            'en.name'    => ['nullable', 'string', setValidationLang('en')],
            'code'       => ['required', 'string', 'unique:specs,code', setValidationLang('en')],
            'type'       => ['required', 'string', Rule::in(array_keys(Spec::types()))],
            'dropdown'   => [$required, 'string', Rule::in(array_keys(Spec::dropdown()))],
            'colors.*'   => [$required_color],
            'names_ar.*' => [$required, 'string', setValidationLang('ar')],
            'names_en.*' => [$required, 'string', setValidationLang('en')],
        ];
    }
}
