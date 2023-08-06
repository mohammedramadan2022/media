<?php

namespace App\Repository\Eloquent\Sql;

use App\Models\HumanResource;
use App\Repository\Contracts\IHumanResourceRepository;

class HumanResourceRepository extends BaseRepository implements IHumanResourceRepository
{
    public function __construct(HumanResource $model)
    {
        parent::__construct($model);
    }
}
