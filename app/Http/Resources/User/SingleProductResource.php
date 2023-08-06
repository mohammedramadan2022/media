<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class SingleProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'product' => ProductDetailsResource::make($this->product),
            'similar' => ProductResource::collection($this->similar),
        ];
    }
}
