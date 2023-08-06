<?php

namespace App\Models;

use App\Casts\Status;
use App\Http\Traits\CityTrait;
use App\Http\Traits\Other\HasImage;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use SoftDeletes, Translatable, CityTrait, HasImage;

    public int $cols = 5;

    public $translationModel = CityTranslation::class;

    public $translationForeignKey = 'city_id';

    public array $translatedAttributes = ['name'];

    protected $casts = ['status' => Status::class];

    public array $fields = [
        ['name' => 'name', 'type' => 'text', 'trans' => 'back.form-name'],
    ];

    public function cityProducts(): HasMany
    {
        return $this->hasMany(Product::class)->with([
            'translation',
            'category.translation',
            'section.translation',
            'images',
        ]);
    }
}
