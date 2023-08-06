<?php

namespace App\Repository\Eloquent\Sql;

use App\Models\VacationType;
use App\Repository\Contracts\IVacationTypeRepository;

class VacationTypeRepository extends BaseRepository implements IVacationTypeRepository
{
    public function __construct(VacationType $model)
    {
        parent::__construct($model);
    }
}
