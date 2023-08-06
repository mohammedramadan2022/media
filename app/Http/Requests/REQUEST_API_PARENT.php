<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class REQUEST_API_PARENT extends FormRequest
{
    public function expectsJson(): bool
    {
        return true;
    }

    public function failedValidation(Validator $validator)
    {
        $data['data'] = request()->hasHeader('website') ? $validator->errors() : [];
        $data['status'] = false;
        $data['message'] = $validator->errors()->first();
        $data['error'] = '';

        throw new HttpResponseException(response()->json($data, Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
