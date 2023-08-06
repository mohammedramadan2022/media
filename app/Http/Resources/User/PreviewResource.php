<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class PreviewResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'      => $this->id,
            'section' => SectionResource::make($this->section),
            'image'   => $this->image_url,
            'url'     => $this->url,
        ];
    }
}
