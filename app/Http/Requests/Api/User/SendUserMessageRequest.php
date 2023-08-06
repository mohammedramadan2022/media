<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\REQUEST_API_PARENT;

class SendUserMessageRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'message'     => ['required'],
            'type'        => ['required', 'string', 'in:text,image'],
            'receiver_id' => ['required', 'exists:users,id'],
        ];
    }
}
