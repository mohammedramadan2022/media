<?php

namespace App\Http\Requests\Back;

use App\Rules\NoSpacesRule;
use Illuminate\Foundation\Http\FormRequest;

class EditCouponRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'  => ['required', 'string', new NoSpacesRule(), 'unique:coupons,name,' . $this->coupon->id],
            'value' => ['required', 'string', 'min:1', 'max:100'],
        ];
    }
}
