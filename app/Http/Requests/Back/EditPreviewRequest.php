<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class EditPreviewRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'section_id' => ['required', 'numeric', 'exists:sections,id'],
            'image'      => ['required', 'mimes:png,jpg,jpeg'],
            'url'        => ['required', 'active_url'],
        ];
    }
}
