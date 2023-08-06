<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreSectionWithCategoriesResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'categories'     => CategoryResource::collection($this->categories()->with(['translation'])->active()->get()),
            'products_count' => $this->store_products_count,
        ];
    }
}
