<?php

namespace App\Models;

use App\Casts\Status;
use App\Http\Traits\HumanResourceTrait;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class HumanResource extends Model
{
    use SoftDeletes, Translatable, HumanResourceTrait;

    public int $cols = 5;

    public $translationModel = HumanResourceTranslation::class;

    public $translationForeignKey = 'human_resource_id';

    public array $translatedAttributes = ['title'];

    protected $casts = ['status' => Status::class];

    public array $fields = [
        ['name' => 'title', 'type' => 'text', 'trans' => 'back.form-title'],
    ];
}
