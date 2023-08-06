<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\RepoController;
use App\Http\Requests\Back\{CreateFaqRequest, EditFaqRequest};
use App\Models\Faq;
use App\Repository\Contracts\IFaqRepository;

class FaqController extends RepoController
{
    public function __construct(IFaqRepository $repository)
    {
        parent::__construct($repository);
    }

    public function store(CreateFaqRequest $request)
    {
        return self::repo()->store($request);
    }

    public function update(EditFaqRequest $request, Faq $faq)
    {
        return self::repo()->update($request, $faq);
    }
}
