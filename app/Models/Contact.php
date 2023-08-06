<?php

namespace App\Models;

use App\Facade\Support\Packages\HubSpot;
use App\Http\Traits\ContactTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    use ContactTrait;

    public static function boot(): void
    {
        parent::boot();

        static::created(function ($created) {
            [$firstname, $lastname] = explode(' ', $created->name);

            HubSpot::create($firstname, $lastname, $created->email);
        });
    }

    public function mobilePhone(): Attribute
    {
        return Attribute::get(fn () => getFormattedPhone($this->phone));
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
}
