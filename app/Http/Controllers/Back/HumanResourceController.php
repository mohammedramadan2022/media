<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\RepoController;
use App\Http\Requests\Back\{CreateHumanResourceRequest, EditHumanResourceRequest};
use App\Models\HumanResource;
use App\Repository\Contracts\IHumanResourceRepository;

class HumanResourceController extends RepoController
{
    public function __construct(IHumanResourceRepository $repository)
    {
        parent::__construct($repository);
    }

    public function store(CreateHumanResourceRequest $request)
    {
        return self::repo()->store($request);
    }

    public function update(EditHumanResourceRequest $request, HumanResource $humanResource)
    {
        return self::repo()->update($request, $humanResource);
    }
}
