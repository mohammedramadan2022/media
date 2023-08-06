<?php

namespace App\Repository\Eloquent\Sql;

use App\Models\{Preview, Section};
use App\Repository\Contracts\IPreviewRepository;

class PreviewRepository extends BaseRepository implements IPreviewRepository
{
    public function __construct(Preview $model)
    {
        parent::__construct($model);
    }

    public function index()
    {
        $query = $this->model::query()->with(['section', 'section.translation']);

        if ($this->model->translationModel) $query->with('translation');

        $data = [(string) $this->folder->camel() => $query->latest()->paginate(10)];

        return view('Back.'.$this->folder.'.index', $data);
    }

    public function formFields($type = 'create', $currentModel = null): array
    {
        $data = parent::formFields($type, $currentModel);

        $data['sections'] = Section::getInSelectForm();

        return $data;
    }
}
