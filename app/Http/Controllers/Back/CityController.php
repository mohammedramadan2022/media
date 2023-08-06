<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\RepoController;
use App\Http\Requests\Back\{CreateCityRequest, EditCityRequest};
use App\Models\City;
use App\Repository\Contracts\ICityRepository;

class CityController extends RepoController
{
    public function __construct(ICityRepository $repository)
    {
        parent::__construct($repository);
    }

    public function store(CreateCityRequest $request)
    {
        return self::repo()->store($request);
    }

    public function update(EditCityRequest $request, City $city)
    {
        return self::repo()->update($request, $city);
    }
}
