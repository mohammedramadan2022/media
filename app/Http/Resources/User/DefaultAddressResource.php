<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class DefaultAddressResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'full_address' => $this->full_address,
            'city'         => [
                'id'   => $this->city_id,
                'name' => $this->city->name,
            ],
        ];
    }
}
