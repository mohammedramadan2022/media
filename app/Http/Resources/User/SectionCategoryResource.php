<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class SectionCategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'section'    => SectionResource::make($this),
            'categories' => CategoryResource::collection($this->categories),
        ];
    }
}
