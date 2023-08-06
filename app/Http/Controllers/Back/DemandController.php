<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\RepoController;
use App\Models\Demand;
use App\Repository\Contracts\IDemandRepository;

class DemandController extends RepoController
{
    public function __construct(IDemandRepository $repository)
    {
        parent::__construct($repository);
    }

    public function accept(Demand $demand)
    {
        return self::repo()->accept($demand);
    }

    public function reject(Demand $demand)
    {
        return self::repo()->reject($demand);
    }
}
