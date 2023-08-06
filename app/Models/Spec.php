<?php

namespace App\Models;

use App\Casts\Status;
use App\Http\Traits\SpecTrait;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\HasMany;

class Spec extends Model
{
    use SoftDeletes, Translatable, SpecTrait;

    public int $cols = 5;

    public $translationModel = SpecTranslation::class;

    public $translationForeignKey = 'spec_id';

    public array $translatedAttributes = ['name'];

    protected $casts = ['status' => Status::class];

    public array $fields = [
        ['name' => 'name', 'type' => 'text', 'trans' => 'back.form-name'],
    ];

    public function options(): HasMany
    {
        return $this->hasMany(Option::class)->with(['names.translation']);
    }
}
