<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\REQUEST_API_PARENT;
use App\Rules\PasswordRule;
use Illuminate\Contracts\Validation\Validator;

class SetNewPasswordRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'phone'    => ['required', 'numeric'],
            'password' => ['required', 'string', new PasswordRule()],
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
