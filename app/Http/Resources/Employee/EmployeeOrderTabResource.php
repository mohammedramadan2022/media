<?php

namespace App\Http\Resources\Employee;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeOrderTabResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'             => $this->id,
            'order_no'       => $this->order_no,
            'created_at'     => $this->created_at->format('Y/m/d'),
            'start_date'     => $this->start_date->format('Y/m/d'),
            'start_time'     => localizeDate(Carbon::parse($this->start_time)->format('H:i A')),
            'end_date'       => $this->end_date->format('Y/m/d'),
            'end_time'       => localizeDate(Carbon::parse($this->end_time)->format('H:i A')),
            'order_status'   => $this->status,
            'payment_status' => $this->payment_status,
            'delivery_type'  => $this->delivery_type,
            'addresses'      => Product::getAllOrderAddresses($this),
            'payment'        => [
                'is_paid'         => $this->is_payed,
                'payment_method'  => $this->is_payed ? trans('back.' . $this->payment_method) : '',
                'coupon'          => $this->coupon ?? '',
                'discount'        => $this->discount,
                'total'           => $this->total,
                'tax'             => $this->tax,
                'total_insurance' => $this->total_insurance,
                'delay_penalty'   => (string)$this->delay_penalty,
                'delayed_days'    => (string)$this->delayed_days,
                'currency'        => trans('back.reyal'),
            ],
        ];
    }
}
