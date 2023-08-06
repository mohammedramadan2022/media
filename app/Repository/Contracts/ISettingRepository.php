<?php

namespace App\Repository\Contracts;

use App\Models\Setting;
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
interface ISettingRepository
{
    public function createSetting(Request $request);

    public function updateSetting(Request $request, Setting $setting);

    public function updateAll(Request $request);

    public function configurations(Request $request);
}
