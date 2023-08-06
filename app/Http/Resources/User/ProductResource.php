<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'name'        => limit($this->name, 70),
            'price'       => $this->price,
            'hour_price'  => $this->hour_price,
            'image'       => $this->first_image_url,
            'has_offer'   => (bool)$this->has_offer,
            'offer'       => $this->offer ?? '0%',
            'offer_value' => $this->offer_value,
            'section'     => SectionResource::make($this->section),
            'category'    => CategoryResource::make($this->category),
            'currency'    => trans('back.reyal'),
            'is_fave'     => $this->is_fave,
            'is_in_cart'  => $this->is_in_cart,
        ];
    }
}
