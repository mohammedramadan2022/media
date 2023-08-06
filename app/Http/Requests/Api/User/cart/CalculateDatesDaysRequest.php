<?php

namespace App\Http\Requests\Api\User\cart;

use App\Http\Requests\REQUEST_API_PARENT;
use App\Rules\CheckEndDateRule;
use App\Rules\CheckStartDateRule;

class CalculateDatesDaysRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'startDate' => ['nullable', 'date_format:Y-m-d', new CheckStartDateRule()],
            'endDate'   => ['nullable', 'date_format:Y-m-d', new CheckEndDateRule()],
        ];
    }
}
