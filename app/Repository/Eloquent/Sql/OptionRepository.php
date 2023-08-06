<?php

namespace App\Repository\Eloquent\Sql;

use App\Models\Option;
use App\Repository\Contracts\IOptionRepository;

class OptionRepository extends BaseRepository implements IOptionRepository
{
    public function __construct(Option $model)
    {
        parent::__construct($model);
    }
}
