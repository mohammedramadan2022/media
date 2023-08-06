<?php

namespace App\Models;

use App\Casts\Status;
use App\Http\Traits\VacationTypeTrait;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class VacationType extends Model
{
    use SoftDeletes, Translatable, VacationTypeTrait;

    public int $cols = 5;

    public $translationModel = VacationTypeTranslation::class;

    public $translationForeignKey = 'vacation_type_id';

    public array $translatedAttributes = ['name'];

    protected $casts = ['status' => Status::class];

    public array $fields = [
        ['name' => 'name', 'type' => 'text', 'trans' => 'back.form-name'],
    ];
}
