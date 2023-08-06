<?php

namespace App\Models;

use App\Casts\Status;
use App\Http\Traits\CouponTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Coupon extends Model
{
    use SoftDeletes, CouponTrait;

    public int $cols = 5;

    protected $casts = ['status' => Status::class];

    public function couponable(): MorphTo
    {
        return $this->morphTo();
    }

    public function ownership(): Attribute
    {
        return Attribute::get(function() {
            if ($this->couponable_type == Admin::class) {
                return "<span class='badge p-2 display-block f-16 badge-light-warning'>".trans('back.rental').'</span>';
            }

            $store_name = Provider::select(['store_name'])->where('id', $this->couponable_id)->value('store_name');

            return "<span class='badge p-2 display-block f-16 badge-light-dark'>".ucwords($store_name).'</span>';
        });
    }
}
