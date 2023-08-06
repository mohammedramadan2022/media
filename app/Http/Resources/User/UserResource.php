<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'              => $this->id,
            'first_name'      => $this->first_name,
            'last_name'       => $this->last_name,
            'phone'           => $this->phone,
            'identity'        => $this->identity_image_url ?? '',
            'identity_number' => $this->identity_number ?? '',
            'address_id'      => $this->address_id ?? 0,
            'email'           => $this->email,
            'whatsapp'        => $this->whatsapp,
            'is_active'       => $this->is_active,
            'city'            => CityResource::make($this->city),
            'app_access_code' => $this->app_access_code,
            'cart_id'         => $this->cart->id ?? 0,
            'wallet_balance'  => $this->wallet ?? 0,
            'jwt'             => $this->token->jwt ?? '',
        ];
    }
}
