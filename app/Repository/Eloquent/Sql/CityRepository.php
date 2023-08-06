<?php

namespace App\Repository\Eloquent\Sql;

use App\Facade\Support\Core\Crud;
use App\Models\City;
use App\Repository\Contracts\ICityRepository;
use Illuminate\Http\Request;

class CityRepository extends BaseRepository implements ICityRepository
{
    public function __construct(City $model)
    {
        parent::__construct($model);
    }

    public function store(Request $request)
    {
        $modelData = $request->all();

        $modelData['slug'] = random(3).slug($modelData['ar']['name']);

        return Crud::storeTranslatedModel($this->class, $modelData, false);
    }

    public function update(Request $request, $currentModel)
    {
        $modelData = $request->all();

        $modelData['slug'] = random(3).slug($modelData['ar']['name']);

        return Crud::updateTranslatedModel($this->class, $modelData, $currentModel, false);
    }
}
