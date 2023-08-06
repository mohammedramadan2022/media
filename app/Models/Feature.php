<?php

namespace App\Models;

use App\Casts\Status;
use App\Http\Traits\FeatureTrait;
use App\Http\Traits\Other\HasImage;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Feature extends Model
{
    use SoftDeletes, FeatureTrait, HasImage;

    public int $cols = 5;

    protected $guarded = ['id'];

    protected $casts = ['status' => Status::class];
}
