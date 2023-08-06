<?php

namespace App\Http\Resources\Employee;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'email'   => $this->email,
            'phone'   => $this->phone ?? '',
            'image'   => $this->image_url,
            'address' => $this->address ?? '',
            'role'    => [
                'id'   => $this->role_id,
                'name' => $this->role->name,
            ],
            'city'    => ['id' => $this->city_id, 'name' => $this->city?->name ?? ''],
            'jwt'     => $this->token->jwt,
        ];
    }
}
