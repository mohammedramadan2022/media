<?php

namespace App\Http\Requests\Api\User\orders;

use App\Http\Requests\REQUEST_API_PARENT;
use Illuminate\Contracts\Validation\Validator;

class SetUserOrderPayRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'order_id'     => ['required', 'numeric', 'exists:orders,id'],
            'card_holder'  => ['required', 'string'],
            'card_numbers' => ['required', 'numeric'],
            'card_date'    => ['required', 'string', 'date_format:Y-m'],
            'card_cvv'     => ['required', 'numeric'],
        ];
    }

    protected function getValidatorInstance(): Validator
    {
        $data = $this->all();

        $_date = explode('-', $data['card_date']);

        $data['card_month'] = last($_date);

        $data['card_year'] = head($_date);

        $this->getInputSource()->replace($data);

        return parent::getValidatorInstance();
    }
}
