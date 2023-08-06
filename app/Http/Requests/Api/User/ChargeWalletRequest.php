<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\REQUEST_API_PARENT;
use Illuminate\Contracts\Validation\Validator;

class ChargeWalletRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'amount'       => ['required', 'numeric', 'min:1'],
            'card_holder'  => ['required', 'string'],
            'card_numbers' => ['required', 'string'],
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
