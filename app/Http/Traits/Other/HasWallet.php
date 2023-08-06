<?php

namespace App\Http\Traits\Other;

use App\Models\Wallet;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasWallet
{
    public function isWalletEmpty(): Attribute
    {
        return Attribute::get(fn() => (int)$this->wallet == 0 || is_null($this->wallet));
    }

    public function wallets(): HasMany
    {
        return $this->hasMany(Wallet::class);
    }
}
