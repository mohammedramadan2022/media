<?php

namespace App\Facade\Traits;

use App\Facade\Support\Core\{Firebase, Sms};
use App\Facade\Support\Tools\CrudMessage;
use App\Mail\SendAdminMail;
use Closure;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Http\{JsonResponse, RedirectResponse};
use Illuminate\Support\Facades\{DB, Mail};

trait CrudTrait
{
    public static function block($currentModel): RedirectResponse
    {
        DB::beginTransaction();
        try
        {
            $currentModel->block();

            $message = trans('api.this-account-is-blocked');

            Sms::send($currentModel->mobile_phone, $message);

            Mail::to($currentModel->email)->send(new SendAdminMail($message, 'رسالة حظر'));

            DB::commit();

            return CrudMessage::success();
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return CrudMessage::error($e);
        }
    }

    public static function unblock($currentModel): RedirectResponse
    {
        DB::beginTransaction();
        try
        {
            $currentModel->unBlock();

            $message = trans('api.user-account-unblocked');

            Sms::send($currentModel->mobile_phone, $message);

            Mail::to($currentModel->email)->send(new SendAdminMail($message,'رسالة حظر'));

            DB::commit();

            return CrudMessage::success();
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return CrudMessage::error($e);
        }
    }

    public static function setStatus($model, $request, $withoutMessage = false): ?JsonResponse
    {
        $model_name = getModelName($model);

        $name = trans('back.'.plural_parts($model_name).'.'.plural_parts($model_name)->singular());

        $object = $model::find($request->id);

        if (! $object) {
            return CrudMessage::fails(trans('api.model-not-found', ['var' => trans('back.'.$model_name)]));
        }

        if (! self::updateStatus($request->all(), $object)) return CrudMessage::fails();

        set_admin_activity($object, 'قام '.admin('name').' بتغير حالة '.$name);

        return $withoutMessage ? null : CrudMessage::edit($model_name);
    }

    public static function sendModelMessage($model, $request): RedirectResponse
    {
        try
        {
            $type = $request->type ?? '';

            $query = $model::query();

            if (!in_array($type, ['', 'all'])) $query->where('type', $type);

            $eloquent = $query->get();

            return CrudMessage::success();
        }
        catch (Exception $e)
        {
            return CrudMessage::error($e);
        }
    }

    public static function sendModelNotification($modelClass, $request): RedirectResponse
    {
        DB::beginTransaction();
        try
        {
            Firebase::push($request->title, $request->body, $modelClass::find($request->user_id));

            DB::commit();

            return CrudMessage::success();
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return CrudMessage::error($e);
        }
    }

    public static function sendPluralModelNotification($modelClass, $request): RedirectResponse
    {
        DB::beginTransaction();
        try
        {
            $query = $modelClass::query();

            $query->whereHas('fcm', fn (Builder $query) => $query->whereNotNull('fcm'));

            $users = $query->get();

            $users->map(fn ($model) => Firebase::push(request('title'), request('body'), $model));

            $tokens = $users->map->fcm->pluck('fcm')->toArray();

            Firebase::combineLangByTopic($request, $tokens,'users');

            DB::commit();

            return CrudMessage::success();
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return CrudMessage::error($e);
        }
    }

    public static function saveTranslatedAttrs($model, $formTranslatedAttrs, $otherAttrs = null, $excepted = []): void
    {
        foreach (sitelangs() as $lang => $name)
        {
            foreach ($model->translatedAttributes as $attr)
            {
                $model->translateOrNew($lang)->$attr = $formTranslatedAttrs[$lang][$attr];
            }
        }

        if ($otherAttrs != null)
        {
            $otherAttrs = except($otherAttrs,['_method', '_token'] + $excepted);

            foreach ($otherAttrs as $key => $value)
            {
                $model->$key = $value;
            }
        }
    }

    public static function load_translated_attrs($model): void
    {
        foreach (sitelangs() as $lang => $name) {
            $model->$lang = [];

            foreach ($model->translatedAttributes as $attr) {
                $model->$lang = $model->$lang + [$attr => $model->getTranslation($lang)->$attr];
            }
        }
    }

    public static function getModelsInSelectedForm($model, string $name = 'name', bool $withIds = true, array $exceptedIds = [], Closure $callback = null, array $withRelations = []): array
    {
        $list = [];

        $query = $model::query();

        if (count($withRelations) > 0) $query->with($withRelations);

        $query->whereNotIn('id', $exceptedIds)->where('status', 1);

        if ($callback instanceof Closure) $query->where($callback($query));

        $modelsDB = $query->get();

        if ($withIds)
        {
            foreach ($modelsDB as $modelDB) {
                $list[$modelDB->id] = ucwords($modelDB->$name);
            }
        }
        else
        {
            foreach ($modelsDB as $modelDB)
            {
                $list[$modelDB->$name] = ucwords($modelDB->$name);
            }
        }

        return $list;
    }

    public static function getModelWithTokens($model): array
    {
        $collection = $model::whereHas('fcm', fn (Builder $query) => $query->whereNotNull('fcm'))->get();

        $withTokens = [];

        foreach ($collection as $index => $result)
        {
            $withTokens[$index]['full_name'] = $result->full_name;
            $withTokens[$index]['fcm'] = $result->fcm->fcm;
        }

        return $withTokens;
    }

    // helpers

    public static function setBasics($data, $other, $model): object
    {
        $modelData = ! is_array($data) ? $data->validated() : $data;

        $modelData['status'] = $data['status'] ?? false;

        $finalModelData = array_merge($modelData, $other);

        $text = getModelName($model)->lower();

        $validatedModelData = Arr::except($finalModelData, ['_token', 'images', '_method', 'is-main-category', 'password_confirmation']);

        $the_model_data = [];

        foreach ($validatedModelData as $key => $value)
        {
            if (str($key)->contains(['image', 'photo', 'background', 'poster', 'logo', 'pdf', 'file']) && is_null($value)) continue;

            $the_model_data[$key] = $value;
        }

        return (object) ['modelData' => $the_model_data, 'model_name' => (string) $text, 'image_folder' => (string) $text->plural()];
    }

    private static function updateStatus($data, $model): bool
    {
        // if the value comes with checked that mean we want the reverse value of it;
        return ($data['value'] == 'checked') ? $model->update(['status' => 0]) : $model->update(['status' => 1]);
    }

    public static function explode($data): array
    {
        $formTranslatedAttrs = Arr::only($data, array_keys(sitelangs()));

        $data = Arr::except($data, array_keys(sitelangs()));

        return [$data, $formTranslatedAttrs];
    }
}
