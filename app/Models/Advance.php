<?php

namespace App\Models;

use App\Enums\AdvanceEnum;
use App\Http\Traits\AdvanceTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Advance extends Model
{
    use SoftDeletes, AdvanceTrait;

    public int $cols = 5;

    protected $casts = ['date' => 'datetime'];

    protected $with = ['admin'];

    public function status(): Attribute
    {
        return Attribute::get(function() {
            if (is_null($this->is_accepted)) return AdvanceEnum::PENDING;

            return $this->is_accepted == 1 ? AdvanceEnum::ACCEPTED : AdvanceEnum::REFUSED;
        });
    }

    public function installmentPeriodYear(): Attribute
    {
        return Attribute::get(fn() => match ($this->installment_period) {
            'half_year'    => trans('back.half-year'),
            'quarter_year' => trans('back.quarter-year'),
            'full_year'    => trans('back.full-year'),
        });
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function acceptor(): BelongsTo
    {
        return $this->belongsTo(Admin::class,'acceptor_id');
    }
}
