<?php

namespace App\Models;

use App\Http\Traits\BasicTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class AdminStatus extends Model
{
    use BasicTrait;

    public int $cols = 5;

    protected $appends = [
        'is_available',
    ];

    public function isAvailable(): Attribute
    {
        return Attribute::get(fn () => $this->current_status == 0);
    }
}
