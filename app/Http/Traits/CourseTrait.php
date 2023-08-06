<?php

namespace App\Http\Traits;

use App\Http\Scopes\CourseScopes;
use App\Http\Traits\Api\CourseApi;

trait CourseTrait
{
    use BasicTrait, CourseScopes, CourseApi;
}
