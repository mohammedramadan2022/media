<?php

namespace App\Repository\Eloquent\Sql;

use App\Facade\Support\Core\Crud;
use App\Facade\Support\Tools\CrudMessage;
use App\Models\{Category, Spec, Section};
use App\Repository\Contracts\ICategoryRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\{Arr, Str};
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CategoryRepository extends BaseRepository implements ICategoryRepository
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function index()
    {
        $query = $this->model::query();

        if ($this->model->translationModel) $query->with('section')->with('translation');

        $data = [(string) $this->folder->camel() => $query->latest()->paginate(10)];

        $data['sections'] = Section::getInSelectForm();

        return view('Back.'.$this->folder.'.index', $data);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $category = Crud::storeTranslatedModel($this->class, $request, true, ['slug' => Str::slug($request['ar']['name'])]);

            if(count(Arr::wrap($request->specs)) > 0) $category->specs()->sync($request->specs);

            DB::commit();

            return CrudMessage::successResponse();
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return CrudMessage::fails($e);
        }
    }

    public function update(Request $request, $currentModel)
    {
        DB::beginTransaction();
        try
        {
            $category = Crud::updateTranslatedModel($this->class, $request->except(['specs']), $currentModel, true, ['slug' => Str::slug($request['ar']['name'])]);

            $category->specs()->sync($request->specs);

            DB::commit();

            return CrudMessage::successResponse();
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return CrudMessage::fails($e);
        }
    }

    public function search($request): View
    {
        $sorting = ($request->sorting == 'newer-to-older') ? 'DESC' : 'ASC';

        $query = $this->model::query();

        $query = ($request->has('term') && ! is_null($request->term)) ? $query->search($request->term) : $query;

        if ($this->model->translationModel) $query->with('translation');

        $query = ! is_null($request->section_id) ? $query->where('categories.section_id', $request->section_id) : $query;

        $collection = $query->orderBy('id', $sorting)->paginate(10);

        return view('Back.Categories.index', ['categories' => $collection, 'sections' => Section::getInSelectForm()]);
    }

    public function formFields($type = 'create', $currentModel = null): array
    {
        $data = parent::formFields($type, $currentModel);

        $data['sections'] = Section::getInSelectForm();

        $data['specs'] = Spec::getInSelectForm();

        return $data;
    }
}
