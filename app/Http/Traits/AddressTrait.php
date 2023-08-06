<?php

namespace App\Http\Traits;

use App\Facade\Support\Core\Crud;
use App\Http\Scopes\AddressScopes;
use App\Http\Traits\Api\AddressApi;
use App\Models\Address;
use App\Models\Token;
use Illuminate\Support\Facades\Auth;

trait AddressTrait
{
    use BasicTrait, AddressScopes, AddressApi;

    public static function getDefault()
    {
        if (! $user = Token::whereJwt(getTokenable())->select(['tokenable_id'])->first()) return null;

        Auth::loginUsingId($user->tokenable_id);

        return ((object) auth()->user())->address;
    }

    public static function getInSelectForm(): array
    {
        return Crud::getModelsInSelectedForm(Address::class, 'street');
    }
}
