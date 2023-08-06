<?php

namespace App\Http\Requests\Api\User;

use App\Facade\Support\Tools\MobilePhone;
use App\Http\Requests\REQUEST_API_PARENT;
use App\Rules\EmailFormatChecker;
use Illuminate\Contracts\Validation\Validator;

class CheckUserActiveCodeRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'first_name'      => ['required', 'string', 'min:3', 'max:40'],
            'last_name'       => ['required', 'string', 'min:3', 'max:40'],
            'email'           => ['required', 'email', new EmailFormatChecker(), 'unique:users,email'],
            'phone'           => ['nullable', 'unique:users,phone'],
            'password'        => ['required', 'string', 'min:6'],
            'own_access_code' => ['nullable', 'string', 'exists:users,app_access_code'],
            'device_token'    => ['nullable', 'string'],
            'code'            => ['required', 'numeric'],
        ];
    }

    protected function getValidatorInstance(): Validator
    {
        $data = $this->all();

        $data['phone'] = getPlainPhone(request('phone'));

        $data['code'] = MobilePhone::convertNumTo(request('code'));

        $this->getInputSource()->replace($data);

        return parent::getValidatorInstance();
    }
}
