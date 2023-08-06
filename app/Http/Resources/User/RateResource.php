<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class RateResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'comment' => $this->comment ?? '',
            'rate'    => (float)$this->rate,
            'date'    => $this->created_at->format('Y-m-d'),
            'since'   => $this->since,
        ];
    }
}
