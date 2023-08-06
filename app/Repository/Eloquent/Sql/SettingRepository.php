<?php

namespace App\Repository\Eloquent\Sql;

use App\Facade\Support\Core\{Crud, Uploaded};
use App\Facade\Support\Tools\CrudMessage;
use App\Models\Setting;
use App\Repository\Contracts\ISettingRepository;
use Exception;
use Illuminate\Http\{JsonResponse, Request};
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SettingRepository extends BaseRepository implements ISettingRepository
{
    public function __construct(Setting $model)
    {
        $this->model = $model;

        parent::__construct($model);
    }

    public function index(): View
    {
        return view('Back.'.$this->folder.'.index', ['settings' => $this->model::active()->get()]);
    }

    public function createSetting(Request $request): JsonResponse
    {
        $settingData = $request->all();

        DB::beginTransaction();
        try
        {
            if ($settingData['input'] == 'file') {
                $settingData['value'] = Uploaded::image($settingData['value'], 'setting');
            }

            Setting::updateOrCreate(except($settingData, ['_token']));

            DB::commit();

            return CrudMessage::add('setting');
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return CrudMessage::fails($e);
        }
    }

    public function create(): View
    {
        return view('Back.Crud.create', self::formFields());
    }

    public function updateSetting(Request $request, Setting $setting)
    {
        return Crud::update(Setting::class, $request, $setting);
    }

    public function updateAll(Request $request): JsonResponse
    {
        return $this->model::updateAll($request);
    }

    public function configurations(Request $request): View
    {
        return view('Back.Settings.configurations', ['settings' => $this->model::paginate(30)]);
    }

    public function formFields($type = 'create', $currentModel = null): array
    {
        $data = parent::formFields($type, $currentModel);

        $data['types'] = Setting::types();

        return $data;
    }
}
