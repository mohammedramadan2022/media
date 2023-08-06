<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class VacationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'vacation_type' => ['id' => $this->vacation_type_id, 'name' => $this->vacationType->name],
            'created_at'    => $this->created_at->format('Y/m/d'),
            'days'          => $this->days,
            'status'        => $this->status,
        ];
    }
}
