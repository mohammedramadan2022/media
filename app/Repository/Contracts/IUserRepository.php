<?php

namespace App\Repository\Contracts;

use Illuminate\Http\Request;

/**
 * @method all()
 * @method paginate()
 * @method find($id)
 * @method delete($id)
 * @method forceDelete($id)
 * @method index()
 * @method trashed()
 * @method restore($id)
 * @method search($request)
 * @method export()
 */
interface IUserRepository
{
    public function showUserMessage($id);

    public function sendUserMessage(Request $request);

    public function showUsersNotification();

    public function showUsersMessage();

    public function sendUsersNotification(Request $request);

    public function sendUsersMessage(Request $request);

    public function changeStatus(Request $request);

    public function create();

    public function edit($id);

    public function store(Request $request);

    public function update(Request $request, $currentModel);

    public function block($user);

    public function unblock($user);

    public function sendUserNotification(Request $request);
}
