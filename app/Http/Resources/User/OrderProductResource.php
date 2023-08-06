<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductResource extends JsonResource
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
            'rate'        => round($this->rate) ?? round($this->pivot->rate),
            'rate_count'  => $this->rates_count ?? $this->pivot->rates_count,
            'qty'         => $this->pivot->product_qty,
            'section'     => SectionResource::make($this->section),
            'category'    => CategoryResource::make($this->category),
            'city'        => CityResource::make($this->city),
        ];
    }
}
