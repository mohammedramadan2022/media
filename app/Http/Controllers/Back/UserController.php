<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\RepoController;
use App\Http\Requests\Back\{CreateUserRequest, EditUserRequest, SendUserNotificationRequest, SendUsersNotificationRequest};
use App\Models\User;
use App\Repository\Contracts\IUserRepository;
use Illuminate\Http\Request;

class UserController extends RepoController
{
    public function __construct(IUserRepository $repository)
    {
        parent::__construct($repository);
    }

    public function showUserMessage($id)
    {
        return self::repo()->showUserMessage($id);
    }

    public function sendUserMessage(Request $request)
    {
        return self::repo()->sendUserMessage($request);
    }

    public function sendUserNotification(SendUserNotificationRequest $request)
    {
        return self::repo()->sendUserNotification($request);
    }

    public function showUsersNotification()
    {
        return self::repo()->showUsersNotification();
    }

    public function sendUsersNotification(SendUsersNotificationRequest $request)
    {
        return self::repo()->sendUsersNotification($request);
    }

    public function block(User $user)
    {
        return self::repo()->block($user);
    }

    public function unblock(User $user)
    {
        return self::repo()->unblock($user);
    }

    public function store(CreateUserRequest $request)
    {
        return self::repo()->store($request);
    }

    public function update(EditUserRequest $request, User $user)
    {
        return self::repo()->update($request, $user);
    }
}
