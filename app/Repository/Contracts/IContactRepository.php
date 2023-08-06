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
interface IContactRepository
{
    public function contacts();

    public function showMessageDetails($id);

    public function sendUserMessage($id);

    public function deleteMessage(Request $request);

    public function sendUserReplayMessage(Request $request);
}
