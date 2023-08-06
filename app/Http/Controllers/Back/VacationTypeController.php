<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\RepoController;
use App\Http\Requests\Back\{CreateVacationTypeRequest, EditVacationTypeRequest};
use App\Models\VacationType;
use App\Repository\Contracts\IVacationTypeRepository;

class VacationTypeController extends RepoController
{
    public function __construct(IVacationTypeRepository $repository)
    {
        parent::__construct($repository);
    }

    public function store(CreateVacationTypeRequest $request)
    {
        return self::repo()->store($request);
    }

    public function update(EditVacationTypeRequest $request, VacationType $vacationType)
    {
        return self::repo()->update($request, $vacationType);
    }
}
