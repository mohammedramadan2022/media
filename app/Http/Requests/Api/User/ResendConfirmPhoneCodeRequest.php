<?php

namespace App\Http\Requests\Api\User;

use App\Facade\Support\Tools\MobilePhone;
use App\Http\Requests\REQUEST_API_PARENT;
use App\Rules\MobilePhoneRule;
use Illuminate\Contracts\Validation\Validator;

class ResendConfirmPhoneCodeRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'phone' => ['nullable', 'numeric', 'unique:providers,phone', 'digits_between:9,9', new MobilePhoneRule()],
        ];
    }

    protected function getValidatorInstance(): Validator
    {
        $data = $this->all();

        $data['phone'] = MobilePhone::convertNumTo(request('phone'));

        $this->getInputSource()->replace($data);

        return parent::getValidatorInstance();
    }

    public function messages(): array
    {
        return [
            'phone.digits_between' => trans('api.phone_digits_between', ['num' => '9']),
        ];
    }
}
