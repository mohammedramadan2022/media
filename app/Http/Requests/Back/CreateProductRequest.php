<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    public function rules(): array
    {
        $has_offer = request('has_offer') != '0' ? 'required' : 'nullable';
        $has_insurance = request('has_insurance') != '0' ? 'required' : 'nullable';
        $owner_id = request('ownership') == 'store' && request()->user()->guard == 'admin' ? 'required' : 'nullable';

        return [
            'section_id'            => ['required', 'numeric', 'exists:sections,id'],
            'category_id'           => ['required', 'numeric', 'exists:categories,id'],
            'city_id'               => ['required', 'numeric', 'exists:cities,id'],
            'owner_id'              => [$owner_id, 'numeric', 'exists:providers,id'],
            'qty'                   => ['required', 'numeric', 'min:1'],
            'code'                  => ['required', 'string', 'unique:products,code'],
            'price'                 => ['required', 'numeric', 'min:1'],
            'hour_price'            => ['required', 'numeric', 'min:1'],
            'has_offer'             => ['required', 'in:0,1'],
            'offer'                 => [$has_offer, 'numeric', 'min:1', 'max:100'],
            'has_insurance'         => ['required', 'in:0,1'],
            'insurance'             => [$has_insurance, 'numeric'],
            'images'                => ['required'],
            'images.*'              => ['required', 'mimes:png,jpeg,jpg'],
            'ar.name'               => ['required', 'string', setValidationLang('ar')],
            'en.name'               => ['nullable', 'string', setValidationLang('en')],
            'ar.description'        => ['required', 'string', setValidationLang('ar')],
            'en.description'        => ['nullable', 'string', setValidationLang('en')],
            'ar.rental_terms'       => ['required', 'string', setValidationLang('ar')],
            'en.rental_terms'       => ['nullable', 'string', setValidationLang('en')],
            'ar.usage_instructions' => ['required', 'string', setValidationLang('ar')],
            'en.usage_instructions' => ['nullable', 'string', setValidationLang('en')],
        ];
    }
}
