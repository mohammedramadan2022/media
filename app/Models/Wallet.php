<?php

namespace App\Models;

use App\Enums\WalletEnum;
use App\Http\Traits\WalletTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wallet extends Model
{
    use WalletTrait;

    public int $cols = 5;

    protected $appends = ['balance'];

    public function balance(): Attribute
    {
        return Attribute::get(fn() => (int)optional(request()->user())->wallet);
    }

    public function message(): Attribute
    {
        return Attribute::get(fn() => match ($this->type) {
            WalletEnum::SHIPPED    => trans('back.add-balance-to-wallet', ['var' => $this->amount]),
            WalletEnum::REFUND     => trans('back.balance-refund-to-wallet', ['var' => $this->amount]),
            WalletEnum::DISCOUNTED => trans('back.balance-discounted-from-wallet', ['var' => $this->amount]),
            default                => WalletEnum::UNKNOWN
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
