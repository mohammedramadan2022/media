<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\RepoController;
use App\Http\Requests\Back\{CreateAdminRequest, EditAdminProfileRequest, EditAdminRequest};
use App\Models\Admin;
use App\Repository\Contracts\IAdminRepository;
use Illuminate\Http\Request;

class AdminController extends RepoController
{
    public function __construct(IAdminRepository $repository)
    {
        parent::__construct($repository);
    }

    public function showAdminMessage($id)
    {
        return self::repo()->showAdminMessage($id);
    }

    public function sendAdminMessage(Request $request)
    {
        return self::repo()->sendAdminMessage($request);
    }

    public function sendAdminNotification(Request $request)
    {
        return self::repo()->sendAdminNotification($request);
    }

    public function AdminUpdateProfile(EditAdminProfileRequest $request)
    {
        return self::repo()->updateAdminProfile($request);
    }

    public function adminProfile()
    {
        return self::repo()->adminProfile();
    }

    public function store(CreateAdminRequest $request)
    {
        return self::repo()->store($request);
    }

    public function update(EditAdminRequest $request, Admin $admin)
    {
        return self::repo()->update($request, $admin);
    }
}
