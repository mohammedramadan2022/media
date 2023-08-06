<?php

namespace App\Models;

use App\Casts\Status;
use App\Http\Traits\CategoryTrait;
use App\Http\Traits\Other\Imageable;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany};

class Category extends Model
{
    use SoftDeletes, Translatable, CategoryTrait, Imageable;

    public int $cols = 5;

    public $translationModel = CategoryTranslation::class;

    public $translationForeignKey = 'category_id';

    public array $translatedAttributes = ['name'];

    protected $casts = ['status' => Status::class];

    public array $fields = [
        ['name' => 'name', 'type' => 'text', 'trans' => 'back.form-name'],
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function specs(): BelongsToMany
    {
        return $this->belongsToMany(Spec::class);
    }
}
