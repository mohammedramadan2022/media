<?php

namespace App\Facade\Support\Core;

use App\Facade\Support\Tools\CrudMessage;
use App\Facade\Traits\CrudTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class Crud
{
    use CrudTrait;

    // store functions

    public static function index($model, $folder): View
    {
        $query = $model::query();

        if ($model->translationModel) {
            $query->with('translation');
        }

        $data = [(string) $folder->camel() => $query->latest()->paginate(10)];

        return view('Back.'.$folder.'.index', $data);
    }

    public static function store($model, $data, $withCreated = false, $others = [])
    {
        DB::beginTransaction();
        try
        {
            $basics = self::setBasics($data, $others, $model);

            $created = $model::create($basics->modelData);

            self::uploadImageOrMore(basics: $basics, currentModel: $created);

            DB::commit();

            return $withCreated ? $created : CrudMessage::add($basics->model_name);
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return CrudMessage::fails($e);
        }
    }

    public static function storeWithCreated($model, $request)
    {
        return self::store(model: $model, data: $request, withCreated: true);
    }

    public static function storeActivity($model, $request): JsonResponse
    {
        $object = self::storeWithCreated($model, $request);

        $singular = getModelName($model)->lower();

        $name = trans('back.'.plural($singular).'.'.$singular);

        set_admin_activity($object, 'قام '.admin()->name.' بإضافة '.$name.' جديد(ة)', 'add');

        return CrudMessage::add($singular);
    }

    public static function storeTranslatedModel($model, $request, $withCreated, $other)
    {
        DB::beginTransaction();
        try
        {
            $basics = self::setBasics($request, $other, $model);

            [$modelData, $formTranslatedAttrs] = Crud::explode($basics->modelData);

            $object = new $model($modelData);

            self::saveTranslatedAttrs($object, $formTranslatedAttrs);

            $object->save();

            self::uploadImageOrMore(basics: $basics, currentModel: $object);

            DB::commit();

            return $withCreated ? $object : CrudMessage::add(getModelName($model));
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return CrudMessage::fails($e);
        }
    }

    public static function storeTranslatedModelWithCreated($model, $modelData, $other = [])
    {
        return self::storeTranslatedModel(model: $model, request: $modelData, withCreated: true, other: $other);
    }

    public static function storeTranslatedModelActivity($model, $request): JsonResponse
    {
        $object = self::storeTranslatedModelWithCreated(model: $model, modelData: $request);

        $singular = getModelName($model);

        $name = trans('back.'.plural($singular).'.'.$singular);

        set_admin_activity($object, 'قام '.admin()->name.' بإضافة '.$name.' جديد(ة)', 'add');

        return CrudMessage::add($singular);
    }

    // update functions

    public static function update($model, $request, $currentModel, $withUpdated = false, $others = [])
    {
        DB::beginTransaction();
        try
        {
            $basics = self::setBasics($request, $others, $model);

            $data = except($basics->modelData, ['_method', '_token', 'submit']);

            self::uploadImageOrMore(basics: $basics, type: 'update', currentModel: $currentModel);

            $currentModel->update(except($data, ['image']));

            DB::commit();

            return $withUpdated ? $currentModel : CrudMessage::edit($basics->model_name);
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return CrudMessage::fails($e);
        }
    }

    public static function updateWithUpdated($model, $request, $currentModel)
    {
        return self::update(model: $model, request: $request, currentModel: $currentModel, withUpdated: true);
    }

    public static function updateActivity($model, $request, $currentModel): JsonResponse
    {
        $object = self::updateWithUpdated($model, $request, $currentModel);

        $singular = getModelName($model)->lower();

        $name = trans('back.'.plural($singular).'.'.$singular);

        set_admin_activity($object, ' قام المشرف '.admin()->name.' بتعديل '.$name, 'update');

        return CrudMessage::edit($singular);
    }

    public static function updateTranslatedModel($model, $request, $currentModel, $withUpdated, $other = [])
    {
        DB::beginTransaction();
        try
        {
            $basics = self::setBasics($request, $other, $model);

            [$modelData, $formTranslatedAttrs] = Crud::explode($basics->modelData);

            self::saveTranslatedAttrs($currentModel, $formTranslatedAttrs, $modelData);

            self::uploadImageOrMore(basics: $basics, type: 'update', currentModel: $currentModel);

            $currentModel->save();

            DB::commit();

            return $withUpdated ? $currentModel : CrudMessage::edit(getModelName($model));
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return CrudMessage::fails($e);
        }
    }

    public static function updateTranslatedModelWithUpdated($model, $request, $currentModel, $other = [])
    {
        return self::updateTranslatedModel(model: $model, request: $request, currentModel: $currentModel, withUpdated: true, other: $other);
    }

    public static function updateTranslatedModelActivity($model, $request, $currentModel): JsonResponse
    {
        $object = self::updateTranslatedModelWithUpdated($model, $request, $currentModel);

        $singular = getModelName($model);

        $name = trans('back.'.plural($singular).'.'.$singular);

        if (admin('role_id') != 1) {
            set_admin_activity($object, ' قام المشرف '.admin()->name.' بتعديل '.$name, 'update');
        }

        return CrudMessage::edit($singular);
    }

    // delete function

    public static function delete($model, $id, $withoutMessage = false): ?JsonResponse
    {
        $model_name = getModelName($model);

        if (! $currentModel = $model::findOrFail($id)) {
            return CrudMessage::fails("Sorry, $model_name is not exists !!");
        }

        DB::beginTransaction();
        try {
            $name = trans('back.'.plural($model_name).'.'.$model_name);

            //            set_admin_activity($currentModel,"قام " . admin()->name . " بحذف " . $name,'delete');

            $currentModel->delete();

            DB::commit();

            return CrudMessage::delete($model_name);
        } catch (Exception $e) {
            DB::rollBack();

            return $withoutMessage ? null : CrudMessage::deleteResponseFails($e);
        }
    }

    // set boolean column value function

    public static function setBooleanColumnValue($model, $column, $value, $withoutResponse = false)
    {
        DB::beginTransaction();
        try {
            $model_name = singular($model->getTable());

            $name = trans('back.'.plural($model_name).'.'.$model_name);

            $result = $model->update([$column => $value]);

            set_admin_activity($model, 'قام '.admin('name').' بتغير حالة '.$name, 'update');

            DB::commit();

            return $withoutResponse ? $result : CrudMessage::edit($model_name);
        } catch (Exception $e) {
            DB::rollBack();

            return CrudMessage::fails($e);
        }
    }

    public static function uploadImageOrMore($basics, $type = 'create', $currentModel = null): void
    {
        $data = [];

        $modelData = array_filter($basics->modelData);

        if ($type == 'create') {
            foreach ($modelData as $key => $input) {
                if (is_array($input) || ! is_file($input)) {
                    continue;
                }

                if (method_exists($currentModel, $key)) {
                    continue;
                }

                $data[$key] = is_pdf($input) ? Uploaded::file($input) : Uploaded::image($input, $basics->model_name);
            }
        }

        if ($type == 'update') {
            foreach ($modelData as $key => $input) {
                if (is_array($input) || ! is_file($input)) {
                    continue;
                }

                if (method_exists($currentModel, $key)) {
                    continue;
                }

                $file_name = app(getClass($basics->model_name))->find($currentModel->id)->$key;

                $data[$key] = is_pdf($input) ? Uploaded::file($input, $file_name) : Uploaded::image($input, $basics->model_name, $file_name);
            }
        }

        if (method_exists($currentModel, 'image') || method_exists($currentModel, 'images')) {
            if (! is_array(request('image'))) {
                Uploaded::upload($currentModel, 'image', $basics->image_folder);
            }

            if (is_array(request('images')) && count(request('images')) > 0 && head(request('images')) != null) {
                Uploaded::multi($currentModel, request('images'), $basics->model_name);
            }
        }

        if (! empty($data)) {
            $currentModel->update($data);
        }
    }
}
