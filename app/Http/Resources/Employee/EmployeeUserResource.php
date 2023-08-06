<?php

namespace App\Http\Resources\Employee;

use App\Enums\OrderStatus;
use App\Http\Resources\User\CityResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeUserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'         => $this->user_id,
            'first_name' => $this->user->first_name,
            'last_name'  => $this->user->last_name,
            'phone'      => $this->user->phone,
            'city'       => CityResource::make($this->user->city),
            'addresses'  => Product::getProvidersAddresses($this->products),
            'orders'     => [
                'total'    => $this->user->orders()->count(),
                'new'      => $this->user->orders()->where('status', OrderStatus::PENDING)->count(),
                'canceled' => $this->user->orders()->where('status', OrderStatus::CANCELED)->count(),
                'rejected' => $this->user->orders()->where('status', OrderStatus::REJECTED)->count(),
                'done'     => $this->user->orders()->where('status', OrderStatus::RECEIVED)->count(),
            ],
        ];
    }
}
