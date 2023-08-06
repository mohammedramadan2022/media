<?php

namespace App\Http\Resources\Employee;

use App\Http\Resources\User\CategoryResource;
use App\Http\Resources\User\SectionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name ?? $this->pivot->product_name,
            'price'       => $this->price ?? $this->pivot->product_price,
            'has_offer'   => (bool)$this->has_offer,
            'offer_value' => $this->offer_value,
            'image'       => $this->first_image_url ?? $this->pivot->product_image,
            'qty'         => $this->pivot->product_qty,
            'section'     => SectionResource::make($this->section),
            'category'    => CategoryResource::make($this->category),
            'insurance'   => $this->insurance ?? '0',
            'currency'    => trans('back.reyal'),
        ];
    }
}
