<?php

namespace App\Http\Resources\User;

use App\Models\Cart;
use Illuminate\Http\Resources\Json\JsonResource;

class ShoppingCartResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'products'  => ShoppingCartProductResource::collection($this->products),
            'addresses' => Cart::getCartLocationAddresses(),
            'summary'   => [
                'subtotal'        => round($this->subtotal),
                'total_insurance' => round($this->total_insurance),
                'tax'             => round($this->tax),
                'total'           => round($this->total),
                'currency'        => trans('back.reyal'),
            ],
            'coupon'    => [
                'discount' => '',
                'total'    => '',
            ],
        ];
    }
}
