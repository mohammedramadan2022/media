<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'             => $this->id,
            'order_no'       => $this->order_no,
            'created_at'     => $this->created_at->format('Y/m/d'),
            'total'          => $this->total,
            'currency'       => trans('back.reyal'),
            'payment_status' => $this->payment_status,
            'order_status'   => $this->status,
        ];
    }
}
