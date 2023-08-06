<?php

namespace App\Models;

use App\Http\Traits\NotificationTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Notification extends Model
{
    use NotificationTrait;

    protected $guarded = ['id'];

    protected $with = ['notificationable'];

    public function notificationable(): MorphTo
    {
        return $this->morphTo();
    }
}
