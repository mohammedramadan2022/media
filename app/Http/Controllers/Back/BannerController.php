<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\RepoController;
use App\Http\Requests\Back\{CreateBannerRequest, EditBannerRequest};
use App\Models\Banner;
use App\Repository\Contracts\IBannerRepository;

class BannerController extends RepoController
{
    public function __construct(IBannerRepository $repository)
    {
        parent::__construct($repository);
    }

    public function store(CreateBannerRequest $request)
    {
        return self::repo()->store($request);
    }

    public function update(EditBannerRequest $request, Banner $banner)
    {
        return self::repo()->update($request, $banner);
    }
}
