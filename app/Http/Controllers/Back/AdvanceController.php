<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\RepoController;
use App\Models\Advance;
use App\Repository\Contracts\IAdvanceRepository;

class AdvanceController extends RepoController
{
    public function __construct(IAdvanceRepository $repository)
    {
        parent::__construct($repository);
    }

    public function accept(Advance $advance)
    {
        return self::repo()->accept($advance);
    }

    public function refuse(Advance $advance)
    {
        return self::repo()->refuse($advance);
    }
}
