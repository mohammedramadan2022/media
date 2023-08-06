<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class SendNotificationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'ar.title' => ['required', 'string', setValidationLang('ar')],
            'en.title' => ['required', 'string', setValidationLang('en')],
            'ar.body'  => ['required', 'string', setValidationLang('ar')],
            'en.body'  => ['required', 'string', setValidationLang('en')],
            'type'     => ['required', 'string', 'in:users,user,providers,provider'],
        ];
    }
}
