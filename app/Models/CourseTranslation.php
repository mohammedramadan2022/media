<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseTranslation extends Model
{
    public $timestamps = false;

    protected $table = 'course_translations';

    protected $guarded = ['id'];
}
