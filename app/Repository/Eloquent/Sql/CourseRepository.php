<?php

namespace App\Repository\Eloquent\Sql;

use App\Models\Course;
use App\Repository\Contracts\ICourseRepository;

class CourseRepository extends BaseRepository implements ICourseRepository
{
    public function __construct(Course $model)
    {
        parent::__construct($model);
    }
}
