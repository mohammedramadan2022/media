<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class ProviderRatesResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'rate'       => (string)$this->rate,
            'rates'      => RateResource::collection($this->rates),
            'rate_count' => $this->rates_count,
        ];
    }
}
