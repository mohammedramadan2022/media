<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class FeatureResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'    => $this->id,
            'image' => $this->image_url,
            'url'   => $this->url,
        ];
    }
}
