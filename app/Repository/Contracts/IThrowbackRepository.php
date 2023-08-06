<?php

namespace App\Repository\Contracts;

use App\Models\Throwback;

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
interface IThrowbackRepository
{
    public function accept(Throwback $throwback);

    public function refuse(Throwback $throwback);
}
