<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\REQUEST_API_PARENT;
use App\Rules\EmailFormatChecker;
use App\Rules\PasswordMinRule;
use Illuminate\Contracts\Validation\Validator;

class RegisterRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'first_name'      => ['required', 'string', 'min:3', 'max:40'],
            'last_name'       => ['required', 'string', 'min:3', 'max:40'],
            'email'           => ['required', 'email:filter', new EmailFormatChecker(), 'unique:users,email'],
            'phone'           => ['required', 'unique:users,phone'],
            'whatsapp'        => ['nullable', 'unique:users,whatsapp'],
            'password'        => ['required', 'string', new PasswordMinRule(6)],
            'own_access_code' => ['nullable', 'string', 'exists:users,app_access_code'],
            'device_token'    => ['nullable', 'string'],
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
