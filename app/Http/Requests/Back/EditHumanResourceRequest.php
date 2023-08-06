<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class EditHumanResourceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'ar.title'  => ['required', 'string', 'min:3', setValidationLang('ar')],
            'en.title'  => ['nullable', 'string', 'min:3', setValidationLang('en')],
            'video_url' => ['required', 'url'],
        ];
    }
}
