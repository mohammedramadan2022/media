<?php

namespace App\Http\Requests\Api\User\cart;

use App\Http\Requests\REQUEST_API_PARENT;
use App\Rules\{CheckEndDateRule, CheckStartDateRule, CheckStartTimeRule};
use Illuminate\Contracts\Validation\Validator;

class ValidateShoppingCartDatesRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'startDate' => ['required', 'date_format:Y-m-d', new CheckStartDateRule()],
            'startTime' => ['required', 'date_format:H:i', new CheckStartTimeRule()],
            'endDate'   => ['required', 'date_format:Y-m-d', 'after:startDate', new CheckEndDateRule()],
        ];
    }

    protected function getValidatorInstance(): Validator
    {
        $data = $this->all();

        $data['endTime'] = request('endTime') != '--:-- --' ? request()->date('endTime')->format('H:i') : null;

        $this->getInputSource()->replace($data);

        return parent::getValidatorInstance();
    }
}
