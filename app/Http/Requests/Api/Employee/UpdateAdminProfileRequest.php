<?php

namespace App\Http\Requests\Api\Employee;

use App\Facade\Support\Tools\MobilePhone;
use App\Http\Requests\REQUEST_API_PARENT;
use App\Rules\EmailFormatChecker;
use Illuminate\Contracts\Validation\Validator;

class UpdateAdminProfileRequest extends REQUEST_API_PARENT
{
    public function rules(): array
    {
        return [
            'name'         => ['nullable', 'string', 'min:3', 'max:40'],
            'email'        => ['nullable', 'email', new EmailFormatChecker(), 'unique:admins,email,' . request()->user()->id],
            'phone'        => ['nullable', 'numeric', 'unique:admins,phone,' . request()->user()->id],
            'city_id'      => ['nullable', 'numeric', 'exists:cities,id'],
            'address'      => ['nullable', 'string', 'min:3'],
            'image'        => ['nullable', 'mimes:png,jpeg,jpg'],
            'device_token' => ['nullable', 'string'],
        ];
    }

    protected function getValidatorInstance(): Validator
    {
        $data = $this->all();

        $data['phone'] = MobilePhone::convertNumTo(request('phone'));

        $this->getInputSource()->replace($data);

        return parent::getValidatorInstance();
    }
}
