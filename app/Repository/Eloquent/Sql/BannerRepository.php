<?php

namespace App\Repository\Eloquent\Sql;

use App\Facade\Support\Core\Crud;
use App\Models\{Banner, Section};
use App\Repository\Contracts\IBannerRepository;
use Illuminate\Http\Request;

class BannerRepository extends BaseRepository implements IBannerRepository
{
    public function __construct(Banner $model)
    {
        parent::__construct($model);
    }

    public function store(Request $request)
    {
        return Crud::store($this->class, self::getBannerData($request));
    }

    public function update(Request $request, $currentModel)
    {
        return Crud::update($this->class, self::getBannerData($request), $currentModel);
    }

    private static function getBannerData($request)
    {
        $bannerData = $request->except(['_token', '_method', 'type_link_id', 'section_id']);

        $bannerData['type'] = 'none';
        $bannerData['type_id'] = null;

        if ($request->type == 'link') {
            $bannerData['type'] = 'link';
            $bannerData['type_id'] = $request->type_link_id;
        }

        if ($request->type == 'product') {
            $bannerData['type'] = 'product';
            $bannerData['type_id'] = $request->type_id;
        }

        if ($request->type == 'section') {
            $bannerData['type'] = 'section';
            $bannerData['type_id'] = $request->section_id;
        }

        return $bannerData;
    }

    public function formFields($type = 'create', $currentModel = null): array
    {
        $data = parent::formFields($type, $currentModel);

        $data['types'] = Banner::types();

        $data['sections'] = Section::getInSelectForm();

        $data['products'] = [];

        return $data;
    }
}
