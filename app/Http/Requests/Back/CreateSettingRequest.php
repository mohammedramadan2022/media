<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class CreateSettingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'key'   => ['required', 'string', 'unique:settings,key'],
            'value' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:1000'],
        ];
    }
}
