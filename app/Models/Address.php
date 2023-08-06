<?php

namespace App\Models;

use App\Casts\Status;
use App\Http\Traits\AddressTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use SoftDeletes, AddressTrait;

    public int $cols = 5;

    protected $casts = ['status' => Status::class];

    public function fullAddress(): Attribute
    {
        return Attribute::get(fn () => $this->city->name.' - '.$this->street.' - '.$this->special_marque);
    }

    public function isAddressSameCity(): Attribute
    {
        return Attribute::get(fn() => request()->user()->cart && $this->city_id != request()->user()->city_id);
    }

    public function isDefault(): Attribute
    {
        return Attribute::get(fn () => $this->id == request()->user()->address_id);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
