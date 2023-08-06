<?php

namespace App\Http\Requests\Back;

use App\Rules\NoSpacesRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateCouponRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'       => ['required', 'string', new NoSpacesRule(), 'min:5', 'unique:coupons,name'],
            'value'      => ['required', 'string', 'min:1', 'max:100'],
            'expired_at' => ['required', 'date', 'after:' . now()->format('Y-m-d')],
        ];
    }
}
