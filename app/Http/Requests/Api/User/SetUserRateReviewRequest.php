<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\REQUEST_API_PARENT;

class SetUserRateReviewRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'course_id'      => ['required', 'numeric', 'exists:courses,id'],
            'course_rate'    => ['required', 'numeric', 'in:1,2,3,4,5'],
            'course_comment' => ['required', 'string', 'min:3', 'max:255'],
            'doctor_id'      => ['required', 'numeric', 'exists:doctors,id'],
            'doctor_rate'    => ['required', 'numeric', 'in:1,2,3,4,5'],
            'doctor_comment' => ['required', 'string', 'min:3', 'max:255'],
        ];
    }
}
