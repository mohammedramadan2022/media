<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\RepoController;
use App\Http\Requests\Back\{CreateSubjectRequest, EditSubjectRequest};
use App\Models\Subject;
use App\Repository\Contracts\ISubjectRepository;

class SubjectController extends RepoController
{
    public function __construct(ISubjectRepository $repository)
    {
        parent::__construct($repository);
    }

    public function store(CreateSubjectRequest $request)
    {
        return self::repo()->store($request);
    }

    public function update(EditSubjectRequest $request, Subject $subject)
    {
        return self::repo()->update($request, $subject);
    }
}
