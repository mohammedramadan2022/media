<?php

namespace App\Repository\Contracts;

use App\Models\Vacation;

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
interface IVacationRepository
{
    public function accept(Vacation $vacation);

    public function refuse(Vacation $vacation);
}
