<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'      => $this->id,
            'image'   => $this->image_url,
            'type'    => $this->type,
            'type_id' => $this->type_id,
        ];
    }
}
