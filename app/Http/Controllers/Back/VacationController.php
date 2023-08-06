<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\RepoController;
use App\Models\Vacation;
use App\Repository\Contracts\IVacationRepository;

class VacationController extends RepoController
{
    public function __construct(IVacationRepository $repository)
    {
        parent::__construct($repository);
    }

    public function accept(Vacation $vacation)
    {
        return self::repo()->accept($vacation);
    }

    public function refuse(Vacation $vacation)
    {
        return self::repo()->refuse($vacation);
    }
}
