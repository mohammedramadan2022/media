<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\RepoController;
use App\Http\Requests\Back\{CreateSettingRequest, EditSettingRequest};
use App\Models\Setting;
use App\Repository\Contracts\ISettingRepository;
use Illuminate\Http\Request;

class SettingController extends RepoController
{
    public function __construct(ISettingRepository $repository)
    {
        parent::__construct($repository);
    }

    public function store(CreateSettingRequest $request)
    {
        return self::repo()->createSetting($request);
    }

    public function update(EditSettingRequest $request, Setting $setting)
    {
        return self::repo()->updateSetting($request, $setting);
    }

    public function UpdateAll(Request $request)
    {
        return self::repo()->updateAll($request);
    }

    public function configurations(Request $request)
    {
        return self::repo()->configurations($request);
    }
}
