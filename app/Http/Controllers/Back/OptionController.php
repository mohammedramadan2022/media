<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\RepoController;
use App\Http\Requests\Back\{CreateOptionRequest, EditOptionRequest};
use App\Models\Option;
use App\Repository\Contracts\IOptionRepository;

class OptionController extends RepoController
{
    public function __construct(IOptionRepository $repository)
    {
        parent::__construct($repository);
    }

    public function store(CreateOptionRequest $request)
    {
        return self::repo()->store($request);
    }

    public function update(EditOptionRequest $request, Option $option)
    {
        return self::repo()->update($request, $option);
    }
}
