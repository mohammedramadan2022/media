<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class ShoppingCartProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'price'       => $this->price,
            'hour_price'  => $this->hour_price,
            'image'       => $this->first_image_url,
            'has_offer'   => (bool)$this->has_offer,
            'offer'       => $this->offer ?? '0%',
            'offer_value' => $this->offer_value,
            'rate'        => round($this->rate),
            'rate_count'  => $this->rates_count,
            'qty'         => $this->qty,
            'cart_qty'    => (int)$this->cart_qty,
            'section'     => SectionResource::make($this->section),
            'category'    => CategoryResource::make($this->category),
            'city'        => CityResource::make($this->city),
            'is_fave'     => $this->is_fave,
        ];
    }
}
