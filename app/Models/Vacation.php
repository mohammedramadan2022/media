<?php

namespace App\Models;

use App\Enums\VacationEnum;
use App\Http\Traits\VacationTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vacation extends Model
{
    use SoftDeletes, VacationTrait;

    public int $cols = 5;

    protected $casts = [
        'from' => 'datetime',
        'to'   => 'datetime',
    ];

    public function status(): Attribute
    {
        return Attribute::get(function() {
            if (is_null($this->is_accepted)) return VacationEnum::PENDING;

            return $this->is_accepted == 1 ? VacationEnum::ACCEPTED : VacationEnum::REFUSED;
        });
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function vacationType(): BelongsTo
    {
        return $this->belongsTo(VacationType::class);
    }

    public function acceptor(): BelongsTo
    {
        return $this->belongsTo(Admin::class,'acceptor_id');
    }
}
