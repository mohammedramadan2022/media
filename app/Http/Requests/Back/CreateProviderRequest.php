<?php

namespace App\Http\Requests\Back;

use App\Rules\EmailFormatChecker;
use Illuminate\Foundation\Http\FormRequest;

class CreateProviderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'       => ['required', 'string', 'min:3'],
            'city_id'    => ['required', 'numeric', 'exists:cities,id'],
            'email'      => ['required', 'email', new EmailFormatChecker(), 'unique:providers'],
            'store_name' => ['required', 'string'],
            'identity'   => ['required', 'numeric'],
            'logo'       => ['required', 'mimes:png,jpeg,jpg'],
            'password'   => ['required', 'min:3'],
        ];
    }
}
