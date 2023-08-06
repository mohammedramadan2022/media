<?php

namespace App\Repository\Eloquent\Sql;

use App\Facade\Support\Core\{Crud, Firebase};
use App\Facade\Support\Tools\CrudMessage;
use App\Mail\SendAdminMail;
use App\Models\User;
use App\Repository\Contracts\IUserRepository;
use Illuminate\Http\{JsonResponse, RedirectResponse, Request};
use Illuminate\Support\Facades\{DB, Mail};

class UserRepository extends BaseRepository implements IUserRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function store(Request $request)
    {
        return Crud::store(model: $this->class, data: $request, others: [
            'app_access_code' => random(8),
            'is_active'       => 1,
        ]);
    }

    public function update(Request $request, $currentModel)
    {
        return Crud::update($this->class, $request, $currentModel);
    }

    public function showUserMessage($id): JsonResponse|string
    {
        if (!$user = $this->find($id)) return CrudMessage::warning(trans('api.user-not-found'));

        return view('Back.Users.sendUserMessageModal', compact('user'))->render();
    }

    public function sendUserMessage(Request $request): RedirectResponse
    {
        if (is_null($request->message)) return CrudMessage::error(trans('api.message-field-is-required'));

        Mail::to($request->email)->send(new SendAdminMail($request->message, $request->title));

        return CrudMessage::success();
    }

    public function sendUserNotification(Request $request): RedirectResponse
    {
        $user = $this->find($request->user_id);

        $res = Firebase::combine($request->title, $request->body, $user);

        if (!$res->status) return CrudMessage::error('Firebase Exception : ' . $res->message);

        return CrudMessage::success();
    }

    public function showUsersNotification(): string
    {
        return view('Back.Users.sendUsersNotificationModal')->render();
    }

    public function sendUsersNotification(Request $request): RedirectResponse
    {
        return Crud::sendPluralModelNotification(User::class, $request);
    }

    public function showUsersMessage(): string
    {
        return view('Back.Users.sendUsersMessageModal')->render();
    }

    public function sendUsersMessage(Request $request): RedirectResponse
    {
        return Crud::sendModelMessage(User::class, $request);
    }

    public function forceDelete($id): RedirectResponse
    {
        DB::transaction(function () use ($id) {
            DB::table('addresses')->where('user_id', $id)->delete();
            DB::table('fcms')->where('fcmable_id', $id)->where('fcmable_type', User::class)->delete();
            DB::table('tokens')->where('tokenable_id', $id)->where('tokenable_type', User::class)->delete();
            DB::table('users')->whereId($id)->delete();
        });

        return CrudMessage::remove($this->name);
    }

    public function block($user): RedirectResponse
    {
        return Crud::block($user);
    }

    public function unblock($user): RedirectResponse
    {
        return Crud::unblock($user);
    }
}
