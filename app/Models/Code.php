<?php

namespace App\Models;

use App\Http\Scopes\CodeScopes;
use App\Http\Traits\CodeTrait;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    use CodeTrait, CodeScopes;

    protected $guarded = ['id'];
}
