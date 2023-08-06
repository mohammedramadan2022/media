<?php

namespace App\Http\Controllers;

use App\Facade\Support\Core\Crud;
use App\Facade\Support\Tools\CrudMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class BaseController extends Controller
{
    public mixed $model;

    public mixed $class;

    public string $export;

    public mixed $modelFolder;

    public function __construct($class)
    {
        $this->model = getModelName($class);
        $this->class = $class;
        $this->export = 'App\Exports\\'.plural($this->model)->ucfirst().'Export';
        $this->modelFolder = plural($this->model);
    }

    public function index()
    {
        $data = [(string) self::folder()->lower() => $this->class::latest()->paginate(10), 'search' => false];

        return view('Back.'.self::folder().'.index', $data);
    }

    public function show($id)
    {
        return view('Back.'.self::folder().'.show', [(string) $this->model => $this->class::find($id)]);
    }

    public function edit($id)
    {
        $obj = $this->class::findOrFail($id);

        if (isset($obj->translatedAttributes) && count($obj->translatedAttributes) > 0) {
            Crud::load_translated_attrs($obj);
        }

        return view('Back.Crud.edit', ['currentModel' => $obj, 'model' => $this->model]);
    }

    public function ChangeStatus(Request $request)
    {
        return $this->class::changeStatus($request);
    }

    public function export()
    {
        return Excel::download(new $this->export, self::folder().'.xlsx');
    }

    public function delete(Request $request)
    {
        return Crud::delete($this->class, $request->id);
    }

    public function trashed()
    {
        return view('Back.'.self::folder().'.trashed', ['trashes' => $this->class::onlyTrashed()->get()]);
    }

    public function forceDelete($id)
    {
        modelForceDelete($this->class, $id);

        return CrudMessage::remove($this->model);
    }

    public function restore($id)
    {
        $model = snake($this->model)->plural();

        DB::table($model)->where('id', $id)->update(['deleted_at' => null]);

        return CrudMessage::restore($this->model);
    }

    public function search(Request $request)
    {
        $folder = self::folder();

        if (is_null($request->term)) return redirect()->route($folder.'.index');

        $data = [(string) $folder->lower() => $this->class::search($request->term)->paginate(10), 'search' => true];

        return view('Back.'.$folder.'.index', $data);
    }

    private function folder()
    {
        return $this->modelFolder->ucfirst();
    }
}
