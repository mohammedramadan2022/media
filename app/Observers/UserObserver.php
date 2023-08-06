<?php

namespace App\Observers;

use App\Models\Fcm;
use App\Models\Token;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    public function created(User $user): void
    {
        Token::createToken($user, ((object)Auth::guard('api'))->fromUser($user),User::class);

        Fcm::createFcm($user,User::class);
    }

    public function forceDeleting(User $user): void
    {
        $user->token()->forceDelete();
        $user->fcm()->forceDelete();
        $user->addresses()->forceDelete();
        $user->favorites()->forceDelete();
        $user->notifications()->forceDelete();
        $user->cart()->forceDelete();
    }
}
