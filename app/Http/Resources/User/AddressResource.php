<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'             => $this->id,
            'recipient_name' => $this->recipient_name,
            'street'         => $this->street,
            'phone'          => $this->phone,
            'special_marque' => $this->special_marque,
            'full_address'   => $this->full_address,
            'is_default'     => $this->is_default,
            'map_url'        => $this->map_url,
            'city'           => CityResource::make($this->city),
        ];
    }
}
