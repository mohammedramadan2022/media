<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\REQUEST_API_PARENT;

class RemoveUserNotificationRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'notification_id' => ['required', 'numeric', 'exists:notifications,id'],
        ];
    }
}
