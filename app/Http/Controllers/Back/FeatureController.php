<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\RepoController;
use App\Http\Requests\Back\{CreateFeatureRequest, EditFeatureRequest};
use App\Models\Feature;
use App\Repository\Contracts\IFeatureRepository;

class FeatureController extends RepoController
{
    public function __construct(IFeatureRepository $repository)
    {
        parent::__construct($repository);
    }

    public function store(CreateFeatureRequest $request)
    {
        return self::repo()->store($request);
    }

    public function update(EditFeatureRequest $request, Feature $feature)
    {
        return self::repo()->update($request, $feature);
    }
}
