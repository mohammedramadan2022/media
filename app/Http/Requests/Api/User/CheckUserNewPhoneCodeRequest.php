<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\REQUEST_API_PARENT;
use App\Rules\MobilePhoneRule;
use Illuminate\Contracts\Validation\Validator;

class CheckUserNewPhoneCodeRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'phone' => ['required', 'numeric', new MobilePhoneRule()],
            'code'  => ['required', 'numeric'],
        ];
    }

    protected function getValidatorInstance(): Validator
    {
        $data = $this->all();

        $data['phone'] = getPlainPhone(request('phone'));

        $this->getInputSource()->replace($data);

        return parent::getValidatorInstance();
    }
}
