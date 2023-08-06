<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\RepoController;
use App\Http\Requests\Back\{CreatePreviewRequest, EditPreviewRequest};
use App\Models\Preview;
use App\Repository\Contracts\IPreviewRepository;

class PreviewController extends RepoController
{
    public function __construct(IPreviewRepository $repository)
    {
        parent::__construct($repository);
    }

    public function store(CreatePreviewRequest $request)
    {
        return self::repo()->store($request);
    }

    public function update(EditPreviewRequest $request, Preview $preview)
    {
        return self::repo()->update($request, $preview);
    }
}
