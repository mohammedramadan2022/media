<?php

namespace App\Http\Traits\Other;

trait Blockable
{
    public function block()
    {
        return $this->update(['blocked_at' => now()]);
    }

    public function unBlock()
    {
        return $this->update(['blocked_at' => null]);
    }

    public function getIsBlockedAttribute(): bool
    {
        return (bool)$this->blocked_at;
    }
}
