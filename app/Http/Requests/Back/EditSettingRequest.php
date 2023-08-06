<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class EditSettingRequest extends FormRequest
{
    public function rules()
    {
        return [
            'key'   => ['required', 'string', 'unique:settings,key,' . $this->setting->id],
            'value' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:1000'],
        ];
    }
}
