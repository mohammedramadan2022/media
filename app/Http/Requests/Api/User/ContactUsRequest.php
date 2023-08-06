<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\REQUEST_API_PARENT;
use App\Rules\EmailFormatChecker;
use App\Rules\WordsCountRule;

class ContactUsRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'name'       => ['required', 'string', new WordsCountRule(2)],
            'phone'      => ['required', 'numeric'],
            'email'      => ['required', 'email', new EmailFormatChecker()],
            'subject_id' => ['required', 'numeric', 'exists:subjects,id'],
            'message'    => ['required', 'string'],
        ];
    }
}
