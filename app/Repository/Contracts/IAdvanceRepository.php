<?php

namespace App\Repository\Contracts;

use App\Models\Advance;

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
interface IAdvanceRepository
{
    public function accept(Advance $advance);

    public function refuse(Advance $advance);
}
