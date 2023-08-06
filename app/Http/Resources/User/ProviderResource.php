<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class ProviderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'store_name'   => $this->store_name,
            'logo'         => $this->logo_url,
            'is_rated'     => $this->is_rated,
            'city'         => CityResource::make($this->city),
            'rate'         => round($this->rate, 1),
            'rates'        => RateResource::collection($this->rates),
            'rate_count'   => $this->rates_count,
            'created_date' => $this->created_at->format('Y/m/d'),
        ];
    }
}
