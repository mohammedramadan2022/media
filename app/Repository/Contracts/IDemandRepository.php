<?php

namespace App\Repository\Contracts;

use App\Models\Demand;

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
interface IDemandRepository
{
    public static function accept(Demand $demand);

    public static function reject(Demand $demand);
}
