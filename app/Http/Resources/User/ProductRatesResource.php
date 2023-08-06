<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductRatesResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'rate'       => (string)round($this->rate, 1),
            'rate_count' => $this->rates_count,
            'rates'      => RateResource::collection($this->rates),
        ];
    }
}
