<?php

namespace App\Http\Resources\Employee;

use App\Http\Resources\User\CityResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeProviderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'name'    => $this->name,
            'phone'   => $this->phone ? getFormattedPhone($this->phone) : '',
            'city'    => CityResource::make($this->city),
            'address' => $this->address,
        ];
    }
}
