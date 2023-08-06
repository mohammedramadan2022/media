<?php

namespace App\Observers;

use App\Enums\RoleEnum;
use App\Models\{Admin, Fcm, Token};
use Illuminate\Support\Facades\Auth;

class AdminObserver
{
    public function created(Admin $admin): void
    {
        $admin->image()->create(['image' => null]);

        Token::createToken($admin, ((object) Auth::guard('admin_api'))->fromUser($admin), Admin::class);

        if ($admin->role_id == RoleEnum::DELIVERY_PROVIDER) $admin->adminStatus()->updateOrCreate(['current_status' => null]);

        Fcm::createFcm($admin, Admin::class);
    }
}
