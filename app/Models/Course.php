<?php

namespace App\Models;

use App\Casts\Status;
use App\Http\Traits\CourseTrait;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Course extends Model
{
    use SoftDeletes, Translatable, CourseTrait;

    public int $cols = 5;

    protected $guarded = ['id'];

    public $translationModel = CourseTranslation::class;

    public $translationForeignKey = 'course_id';

    public array $translatedAttributes = ['title'];

    protected $casts = ['status' => Status::class];

    public array $fields = [
        ['name' => 'title', 'type' => 'text', 'trans' => 'back.form-title'],
    ];
}
