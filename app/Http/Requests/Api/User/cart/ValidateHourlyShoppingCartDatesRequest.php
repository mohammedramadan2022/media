<?php

namespace App\Http\Requests\Api\User\cart;

use App\Http\Requests\REQUEST_API_PARENT;
use App\Rules\{CheckEndDateRule, CheckEndTimeRule, CheckStartDateRule, CheckStartTimeRule};

class ValidateHourlyShoppingCartDatesRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'startDate' => ['required', 'date_format:Y-m-d', new CheckStartDateRule()],
            'startTime' => ['required', 'date_format:H:i', new CheckStartTimeRule()],
            'endDate'   => ['required', 'date_format:Y-m-d', new CheckEndDateRule()],
            'endTime'   => ['required', 'date_format:H:i', new CheckEndTimeRule()],
        ];
    }
}
