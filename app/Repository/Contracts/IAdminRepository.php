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
interface IAdminRepository
{
    public function changeStatus(Request $request);

    public function create();

    public function edit($id);

    public function store(Request $request);

    public function update(Request $request, $currentModel);

    public function showAdminMessage($id);

    public function updateAdminProfile(Request $request);

    public function sendAdminMessage(Request $request);

    public function sendAdminNotification(Request $request);

    public function adminProfile();
}
