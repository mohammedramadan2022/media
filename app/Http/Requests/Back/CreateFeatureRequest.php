<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class CreateFeatureRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'image' => ['required', 'mimes:png,jpeg,jpg'],
            'url'   => ['required', 'active_url'],
        ];
    }
}
