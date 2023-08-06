<?php

namespace App\Http\Traits\Other;

use App\Models\Fcm;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasFcm
{
    public function fcmToken(): Attribute
    {
        return Attribute::get(fn() => $this->fcm()->where('type', 'mobile')->latest()->first()->fcm ?? null);
    }

    public function webFcmToken(): Attribute
    {
        return Attribute::get(fn() => $this->fcm()->where('type', 'web')->latest()->first()->fcm ?? null);
    }

    public function fcm(): MorphMany
    {
        return $this->morphMany(Fcm::class,'fcmable');
    }
}
