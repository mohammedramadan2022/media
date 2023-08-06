<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class CartAddressResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'address' => $this->id,
        ];
    }
}
