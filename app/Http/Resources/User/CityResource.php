<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'       => $this->id,
            'text'     => $this->name,
            'address'  => $this->address,
            'image'    => $this->image_url,
            'products' => $this->cityProducts()->whereNull('type')->where('status', 1)->count(),
        ];
    }
}
