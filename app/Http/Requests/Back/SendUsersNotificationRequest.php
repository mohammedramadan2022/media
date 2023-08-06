<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class SendUsersNotificationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type'     => ['required', 'in:all,users,trainers'],
            'title_ar' => ['required', 'string', setValidationLang('ar')],
            'title_en' => ['required', 'string', setValidationLang('en')],
            'body_ar'  => ['required', 'string', setValidationLang('ar')],
            'body_en'  => ['required', 'string', setValidationLang('en')],
        ];
    }
}
