<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\RepoController;
use App\Http\Requests\Back\{CreateSpecRequest, EditSpecRequest};
use App\Models\Spec;
use App\Repository\Contracts\ISpecRepository;
use Illuminate\Http\Request;

class SpecController extends RepoController
{
    public function __construct(ISpecRepository $repository)
    {
        parent::__construct($repository);
    }

    public function store(CreateSpecRequest $request)
    {
        return self::repo()->store($request);
    }

    public function update(EditSpecRequest $request, Spec $spec)
    {
        return self::repo()->update($request, $spec);
    }

    public function removeOptionById(Request $request)
    {
        return self::repo()->removeOptionById($request);
    }
}
