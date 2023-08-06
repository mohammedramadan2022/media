<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\RepoController;
use App\Http\Requests\Back\{CreateSectionRequest, EditSectionRequest};
use App\Models\Section;
use App\Repository\Contracts\ISectionRepository;

class SectionController extends RepoController
{
    public function __construct(ISectionRepository $repository)
    {
        parent::__construct($repository);
    }

    public function store(CreateSectionRequest $request)
    {
        return self::repo()->store($request);
    }

    public function update(EditSectionRequest $request, Section $section)
    {
        return self::repo()->update($request, $section);
    }
}
