<?php

namespace App\Models;

use App\Casts\Status;
use App\Http\Traits\SubjectTrait;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Subject extends Model
{
    use SoftDeletes, Translatable, SubjectTrait;

    public int $cols = 5;

    public $translationModel = SubjectTranslation::class;

    public $translationForeignKey = 'subject_id';

    public array $translatedAttributes = ['name'];

    protected $casts = ['status' => Status::class];

    public array $fields = [
        ['name' => 'name', 'type' => 'text', 'trans' => 'back.form-name'],
    ];
}
