<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\REQUEST_API_PARENT;
use App\Rules\EmailFormatChecker;
use Illuminate\Contracts\Validation\Validator;

class UpdateUserProfileRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'first_name'      => ['nullable', 'string', 'min:3', 'max:40'],
            'last_name'       => ['nullable', 'string', 'min:3', 'max:40'],
            'phone'           => ['nullable', 'numeric', 'unique:users,phone,' . request()->user()->id],
            'whatsapp'        => ['nullable', 'numeric', 'unique:users,whatsapp,' . request()->user()->id],
            'identity'        => ['nullable', 'mimes:png,jpeg,jpg'],
            'identity_number' => ['nullable', 'numeric'],
            'area_id'         => ['nullable', 'numeric', 'exists:areas,id'],
            'city_id'         => ['nullable', 'numeric', 'exists:cities,id'],
            'email'           => ['nullable', 'email', new EmailFormatChecker(), 'unique:users,email,' . request()->user()->id],
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
