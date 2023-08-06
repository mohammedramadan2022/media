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
interface INotificationRepository
{
    public function create();

    public function store(Request $request);

    public function getListByType($request);
}
