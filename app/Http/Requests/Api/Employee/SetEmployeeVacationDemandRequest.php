<?php

namespace App\Http\Requests\Api\Employee;

use App\Http\Requests\REQUEST_API_PARENT;

class SetEmployeeVacationDemandRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'vacation_type_id' => ['required', 'numeric', 'exists:vacation_types,id'],
            'reason'           => ['required', 'string', 'min:3', 'max:255'],
            'days'             => ['required', 'numeric', 'min:1', 'max:365'],
            'from'             => ['required', 'date_format:Y-m-d'],
            'to'               => ['required', 'date_format:Y-m-d', 'after:from'],
        ];
    }
}
