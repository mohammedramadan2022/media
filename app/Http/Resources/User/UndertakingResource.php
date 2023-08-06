<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UndertakingResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'      => $this->id,
            'content' => $this->content,
            'status'  => $this->action,
        ];
    }
}
