<?php

namespace App\Http\Resources\Employee;

use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeOrderDetailsResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'order'     => EmployeeOrderTabResource::make($this),
            'products'  => EmployeeProductResource::collection($this->products),
            'user'      => EmployeeUserResource::make($this),
            'providers' => EmployeeProviderResource::collection($this->providers)->collection->push(Order::getRentalObject($this)),
            'logger'    => EmployeeLoggerResource::collection($this->loggers),
        ];
    }
}
