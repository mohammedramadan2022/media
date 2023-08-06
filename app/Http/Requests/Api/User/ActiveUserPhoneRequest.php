<?php

namespace App\Http\Requests\Api\User;

use App\Facade\Support\Tools\MobilePhone;
use App\Http\Requests\REQUEST_API_PARENT;
use Illuminate\Contracts\Validation\Validator;

class ActiveUserPhoneRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'phone' => ['required', 'numeric'],
            'code'  => ['required', 'numeric'],
        ];
    }

    protected function getValidatorInstance(): Validator
    {
        $data = $this->all();

        $data['phone'] = setPhoneToDefault(request('phone'));

        $data['code'] = MobilePhone::convertNumTo(request('code'));

        $this->getInputSource()->replace($data);

        return parent::getValidatorInstance();
    }
}
