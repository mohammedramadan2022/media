<?php

namespace App\Models;

use App\Http\Traits\ChatTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class Chat extends Model
{
    use ChatTrait;

    protected $with = ['messages'];

    protected $casts = ['last_message_date' => 'date'];

    public function getUnreadCount(): Attribute
    {
        return Attribute::get(fn() => $this->messages->where('is_seen', 0)->count());
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
