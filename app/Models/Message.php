<?php

namespace App\Models;

use App\Http\Traits\BasicTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use BasicTrait;

    public function imageUrl(): Attribute
    {
        return Attribute::get(fn() => url('public/storage/uploaded/chats/'.$this->message));
    }

    public function fileUrl(): Attribute
    {
        return Attribute::get(function() {
            $type = ($this->type == 'audio') ? $this->type : 'pdf';

            return url('/public/storage/uploaded/chats/'.$type.'/' . $this->message);
        });
    }

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }
}
