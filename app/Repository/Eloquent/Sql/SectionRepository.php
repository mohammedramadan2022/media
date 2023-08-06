<?php

namespace App\Repository\Eloquent\Sql;

use App\Facade\Support\Core\Crud;
use App\Facade\Support\Tools\Icon;
use App\Models\Section;
use App\Repository\Contracts\ISectionRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SectionRepository extends BaseRepository implements ISectionRepository
{
    public function __construct(Section $model)
    {
        parent::__construct($model);
    }

    public function show($id): View
    {
        return view('Back.'.$this->folder.'.show', [
            $this->name => $this->class::where('id', $id)->with(['translation', 'categories.translation'])->first(),
        ]);
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

    public function formFields($type = 'create', $currentModel = null): array
    {
        $data = parent::formFields($type, $currentModel);

        $data['icons'] = Icon::getIcons();

        return $data;
    }
}
