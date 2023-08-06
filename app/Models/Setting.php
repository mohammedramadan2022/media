<?php

namespace App\Models;

use App\Casts\Status;
use App\Http\Traits\SettingTrait;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Setting extends Model
{
    use SoftDeletes, SettingTrait;

    protected $casts = ['status' => Status::class];
}
