<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class EditBannerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'image'        => ['nullable', 'mimes:png,jpg,jpeg'],
            'type'         => ['required', 'string', 'in:link,section,product,none'],
            'type_link_id' => ['required_if:type,link'],
        ];
    }

    public function messages(): array
    {
        return [
            'type_link_id.required_if' => trans('api.type-link-id-is-required'),
        ];
    }
}
