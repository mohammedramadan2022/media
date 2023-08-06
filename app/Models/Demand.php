<?php

namespace App\Models;

use App\Facade\Support\Core\Uploaded;
use App\Http\Traits\DemandTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Demand extends Model
{
    use SoftDeletes, DemandTrait;

    public int $cols = 5;

    public function logoUrl(): Attribute
    {
        return Attribute::get(fn() => Uploaded::defaultImage($this->logo, $this->getTable()));
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
