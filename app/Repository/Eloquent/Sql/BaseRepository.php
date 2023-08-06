<?php

namespace App\Repository\Eloquent\Sql;

use App\Facade\Support\Core\Crud;
use App\Facade\Support\Tools\CrudMessage;
use App\Repository\Contracts\IEloquentRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\{JsonResponse, RedirectResponse, Request};
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BaseRepository implements IEloquentRepository
{
    public Model $model;

    public mixed $folder;

    public mixed $class;

    public mixed $name;

    public mixed $export;

    public function __construct($model)
    {
        $this->model = $model;

        $this->class = getClass(camel($this->model->getTable()));

        $this->name = getModelName($this->class)->camel()->value();

        $this->folder = plural($this->name)->ucfirst();

        $this->export = app('\App\Exports\\'.plural_parts($this->model->getTable())->ucfirst().'Export');
    }

    public function index()
    {
        return Crud::index($this->model, $this->folder);
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function paginate($pages = 10)
    {
        return $this->model::latest()->paginate($pages);
    }

    public function export(): BinaryFileResponse
    {
        return Excel::download($this->export, $this->folder->lower().'.xlsx');
    }

    public function restore($id): RedirectResponse
    {
        $table = $this->model->getTable();

        DB::table($table)->where('id', $id)->update(['deleted_at' => null]);

        return CrudMessage::restore($table);
    }

    public function trashed(): View
    {
        $trashes = $this->model::onlyTrashed()->get();

        return view('Back.'.$this->folder.'.trashed', compact('trashes'));
    }

    public function delete($id): ?JsonResponse
    {
        return Crud::delete($this->class, $id);
    }

    public function show($id): View
    {
        return view('Back.'.$this->folder.'.show', [$this->name => $this->find($id)]);
    }

    public function forceDelete($id): RedirectResponse
    {
        modelForceDelete($this->class, $id);

        return CrudMessage::remove($this->name);
    }

    public function search($request): View
    {
        $element = (string) $this->folder->camel();

        $sorting = $request->sorting == 'newer-to-older' ? 'DESC' : 'ASC';

        $query = $this->model::query();

        $que = ($request->has('term') && ! is_null($request->term)) ? $query->search($request->term) : $query;

        if ($this->model->translationModel) $que->with('translation');

        $collection = $que->orderBy('id', $sorting)->paginate(10);

        return view('Back.'.$this->folder.'.index', [$element => $collection]);
    }

    public function edit($id)
    {
        $currentModel = $this->find($id);

        if (isset($currentModel->translatedAttributes)) Crud::load_translated_attrs($currentModel);

        return view('Back.Crud.edit', $this->formFields('edit', $currentModel));
    }

    public function create(): View
    {
        return view('Back.Crud.create', $this->formFields());
    }

    public function store(Request $request)
    {
        if ($this->model->translationModel) {
            return Crud::storeTranslatedModel($this->class, $this->model::beTranslated(), false);
        }

        return Crud::store($this->class, $request);
    }

    public function update(Request $request, $currentModel)
    {
        if ($this->model->translationModel) {
            return Crud::updateTranslatedModel($this->class, $this->model::beTranslated(), $currentModel, false);
        }

        return Crud::update($this->class, $request, $currentModel);
    }

    public function changeStatus(Request $request): JsonResponse
    {
        return Crud::setStatus($this->class, $request);
    }

    public function formFields($type = 'create', $currentModel = null): array
    {
        $data['model'] = $this->name;

        if ($type == 'edit') $data['currentModel'] = $currentModel;

        return $data;
    }
}
