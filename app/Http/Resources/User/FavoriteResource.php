<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->product->id,
            'name'        => $this->product->name,
            'price'       => $this->product->price,
            'image'       => $this->product->first_image_url,
            'has_offer'   => (bool)$this->product->has_offer,
            'offer'       => $this->product->offer ?? '0%',
            'offer_value' => $this->product->offer_value,
            'rate'        => (int)$this->product->rate,
            'rate_count'  => $this->product->rates_count,
            'qty'         => $this->product->qty,
            'section'     => SectionResource::make($this->product->section),
            'category'    => CategoryResource::make($this->product->category),
            'city'        => CityResource::make($this->product->city),
        ];
    }
}
