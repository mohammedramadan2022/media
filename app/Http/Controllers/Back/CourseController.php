<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\RepoController;
use App\Http\Requests\Back\{CreateCourseRequest, EditCourseRequest};
use App\Models\Course;
use App\Repository\Contracts\ICourseRepository;

class CourseController extends RepoController
{
    public function __construct(ICourseRepository $repository)
    {
        parent::__construct($repository);
    }

    public function store(CreateCourseRequest $request)
    {
        return self::repo()->store($request);
    }

    public function update(EditCourseRequest $request, Course $course)
    {
        return self::repo()->update($request, $course);
    }
}
