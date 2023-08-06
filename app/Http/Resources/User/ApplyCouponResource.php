<?php

namespace App\Http\Resources\User;

use App\Models\Cart;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplyCouponResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'products'  => ShoppingCartProductResource::collection($this->summary->products),
            'addresses' => Cart::getCartLocationAddresses(),
            'summary'   => [
                'subtotal'        => round($this->summary->subtotal),
                'total_insurance' => round($this->summary->total_insurance),
                'tax'             => round($this->summary->tax),
                'total'           => round($this->summary->total),
                'currency'        => trans('back.reyal'),
            ],
            'coupon'    => [
                'discount' => (string)$this->coupon->discount,
                'total'    => (string)$this->coupon->total,
            ],
        ];
    }
}
