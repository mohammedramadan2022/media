<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserOrderAddressResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'address' => $this->address ?? '',
            'phone'   => $this->phone ?? '',
        ];
    }
}
