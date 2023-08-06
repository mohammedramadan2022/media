<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\REQUEST_API_PARENT;

class CheckUserCouponRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'course_id' => ['required', 'numeric', 'exists:courses,id'],
            'coupon'    => ['required', 'string'],
        ];
    }
}
