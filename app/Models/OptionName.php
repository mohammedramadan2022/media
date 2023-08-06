<?php

namespace App\Models;

use App\Casts\Status;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class OptionName extends Model
{
    use SoftDeletes, Translatable;

    public int $cols = 5;

    protected $casts = ['status' => Status::class];

    public $translationModel = OptionNameTranslation::class;

    public $translationForeignKey = 'option_name_id';

    public array $translatedAttributes = ['name'];

    public array $fields = [
        ['name' => 'name', 'type' => 'text', 'trans' => 'back.form-name'],
    ];
}
