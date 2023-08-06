<?php

namespace App\Models;

use App\Casts\Status;
use App\Http\Traits\OptionTrait;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class Option extends Model
{
    use SoftDeletes, OptionTrait;

    public int $cols = 5;

    protected $casts = ['status' => Status::class];

    public function names(): HasMany
    {
        return $this->hasMany(OptionName::class);
    }

    public function spec(): BelongsTo
    {
        return $this->belongsTo(Spec::class);
    }
}
