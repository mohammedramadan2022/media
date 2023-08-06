<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailsResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'                 => $this->id,
            'name'               => $this->name,
            'product_code'       => $this->code,
            'description'        => $this->description,
            'rental_terms'       => $this->rental_terms,
            'usage_instructions' => $this->usage_instructions,
            'qty'                => $this->qty,
            'rate'               => (int)round($this->rate, 1),
            'rate_count'         => $this->rates_count,
            'rates'              => RateResource::collection($this->rates),
            'price'              => $this->price,
            'hour_price'         => $this->hour_price,
            'image'              => $this->first_image_url,
            'images'             => ImageResource::collection($this->images),
            'has_offer'          => (bool)$this->has_offer,
            'offer'              => $this->offer ?? '0%',
            'offer_value'        => $this->offer_value,
            'section'            => SectionResource::make($this->section),
            'city'               => CityResource::make($this->city),
            'category'           => CategoryResource::make($this->category),
            'owner'              => ['id' => (int)$this->type_id ?? 0, 'name' => $this->provider->name ?? ''],
            'is_fave'            => $this->is_fave,
            'currency'           => trans('back.reyal'),
            'is_rated'           => $this->is_rated,
            'is_in_cart'         => $this->is_in_cart,
        ];
    }
}
