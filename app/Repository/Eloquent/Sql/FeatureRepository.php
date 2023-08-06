<?php

namespace App\Repository\Eloquent\Sql;

use App\Models\Feature;
use App\Repository\Contracts\IFeatureRepository;

class FeatureRepository extends BaseRepository implements IFeatureRepository
{
    public function __construct(Feature $model)
    {
        parent::__construct($model);
    }
}
