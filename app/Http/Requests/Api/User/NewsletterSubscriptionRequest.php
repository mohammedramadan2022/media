<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\REQUEST_API_PARENT;
use App\Rules\EmailFormatChecker;

class NewsletterSubscriptionRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', new EmailFormatChecker()],
        ];
    }
}
