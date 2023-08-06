<?php

namespace App\Http\Resources\Employee;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeOrderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'             => $this->id,
            'order_no'       => $this->order_no,
            'start_date'     => $this->start_date->format('Y/m/d'),
            'end_date'       => $this->end_date->format('Y/m/d'),
            'created_at'     => $this->created_at->format('Y/m/d'),
            'payment_status' => $this->payment_status,
            'status'         => $this->status,
        ];
    }
}
