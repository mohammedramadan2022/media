<?php

namespace App\Http\Requests\Api\Employee;

use App\Http\Requests\REQUEST_API_PARENT;

class SetEmployeeAdvanceDemandRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'amount'             => ['required', 'numeric', 'min:1'],
            'reason'             => ['required', 'string', 'min:1', 'max:255'],
            'date'               => ['required', 'date_format:Y-m-d'],
            'installment_period' => ['required', 'string', 'in:quarter_year,half_year,full_year'],
        ];
    }
}
