<?php

namespace App\Models;

use App\Casts\Status;
use App\Http\Traits\BranchTrait;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Branch extends Model
{
    use SoftDeletes, BranchTrait;

    public int $cols = 5;

    protected $casts = ['status' => Status::class];
}
