<?php

namespace App\Models;

use App\Http\Traits\ReasonTrait;
use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{
    use ReasonTrait;

    public int $cols = 5;
}
