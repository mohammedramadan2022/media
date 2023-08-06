<?php

namespace App\Http\Resources\Employee;

use Illuminate\Http\Resources\Json\JsonResource;

class AdvanceResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'                 => $this->id,
            'amount'             => $this->amount,
            'reason'             => $this->reason,
            'date'               => $this->date->format('Y/m/d'),
            'installment_period' => $this->installment_period,
            'status'             => $this->status,
        ];
    }
}
