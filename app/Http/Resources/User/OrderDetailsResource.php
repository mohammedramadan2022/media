<?php

namespace App\Http\Resources\User;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailsResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'             => $this->id,
            'order_no'       => $this->order_no,
            'delivery_type'  => $this->delivery_type,
            'addresses'      => Product::getAllOrderAddresses($this),
            'address'        => UserOrderAddressResource::make($this->addresses->first()),
            'payment_status' => $this->payment_status,
            'order_status'   => $this->status,
            'wallet'         => $this->user->wallet,
            'message'        => $this->wallet_status,
            'invoice_url'    => $this->invoice_url,
            'products'       => OrderProductResource::collection($this->products),
            'summary'        => [
                'created_at'      => $this->created_at->format('Y/m/d'),
                'start_date'      => $this->start_date->format('Y-m-d'),
                'start_time'      => Carbon::parse($this->start_time)->format('Y-m-d H:i'),
                'end_date'        => $this->end_date->format('Y-m-d'),
                'end_time'        => Carbon::parse($this->end_time)->format('Y-m-d H:i'),
                'coupon'          => $this->coupon ?? '',
                'payment_method'  => $this->payment_method,
                'total'           => $this->total,
                'discount'        => $this->discount,
                'tax'             => $this->tax,
                'total_insurance' => $this->total_insurance,
                'delay_penalty'   => (int)$this->delay_penalty,
                'is_delay_paid'   => $this->is_delay_paid,
                'days'            => $this->renting_days ?? 0,
                'hours'           => $this->renting_hours ?? 0,
                'type'            => $this->renting_type ?? '',
                'delayed_days'    => (int)$this->delayed_days ?? 0,
                'currency'        => trans('back.reyal'),
            ],
        ];
    }
}
