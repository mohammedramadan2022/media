<?php

namespace App\Models;

use App\Http\Traits\UndertakingTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Undertaking extends Model
{
    use UndertakingTrait;

    public int $cols = 5;

    public const ACCEPTED = '1';

    public const REFUSED = '0';

    public function action(): Attribute
    {
        return Attribute::get(function () {
            return match ($this->status) {
                self::ACCEPTED => 'undertaking_accepted',
                self::REFUSED  => 'undertaking_refused',
                default        => 'new'
            };
        });
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
}
