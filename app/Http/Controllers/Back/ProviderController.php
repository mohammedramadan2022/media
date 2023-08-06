<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\RepoController;
use App\Http\Requests\Back\{CreateProviderRequest, EditProviderRequest};
use App\Models\Provider;
use App\Repository\Contracts\IProviderRepository;

class ProviderController extends RepoController
{
    public function __construct(IProviderRepository $repository)
    {
        parent::__construct($repository);
    }

    public function store(CreateProviderRequest $request)
    {
        return self::repo()->store($request);
    }

    public function update(EditProviderRequest $request, Provider $provider)
    {
        return self::repo()->update($request, $provider);
    }
}
