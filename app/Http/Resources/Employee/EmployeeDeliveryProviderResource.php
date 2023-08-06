<?php

namespace App\Http\Resources\Employee;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeDeliveryProviderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'                   => $this->id,
            'name'                 => $this->name,
            'image'                => $this->image_url,
            'phone'                => $this->phone ? getFormattedPhone($this->phone) : $this->phone,
            'is_available'         => $this->adminStatus->current_status == 0,
            'ongoing_orders_count' => rand(1, 10),
        ];
    }
}
