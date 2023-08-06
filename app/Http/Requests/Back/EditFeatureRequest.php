<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class EditFeatureRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'image' => ['nullable', 'mimes:png,jpeg,jpg'],
            'url'   => ['required', 'active_url'],
        ];
    }
}
