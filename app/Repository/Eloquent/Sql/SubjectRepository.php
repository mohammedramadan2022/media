<?php

namespace App\Repository\Eloquent\Sql;

use App\Models\Subject;
use App\Repository\Contracts\ISubjectRepository;

class SubjectRepository extends BaseRepository implements ISubjectRepository
{
    public function __construct(Subject $model)
    {
        parent::__construct($model);
    }
}
