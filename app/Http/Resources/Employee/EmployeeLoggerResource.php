<?php

namespace App\Http\Resources\Employee;

use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeLoggerResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'     => $this->admin->id,
            'name'   => $this->admin->name,
            'image'  => $this->admin->image_url,
            'phone'  => $this->admin->phone ? getFormattedPhone($this->admin->phone) : '',
            'role'   => $this->admin->role->name,
            'status' => Order::statuses($this->status),
        ];
    }
}
