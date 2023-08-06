<?php

namespace App\Http\Requests\Api\User\orders;

use App\Http\Requests\REQUEST_API_PARENT;

class GetUndertakingByIdRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'undertaking_id' => ['required', 'numeric', 'exists:undertakings,id'],
        ];
    }
}
