<?php

namespace App\Models;

use App\Casts\Status;
use App\Http\Traits\SectionTrait;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\{Casts\Attribute, Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    use SoftDeletes, Translatable, SectionTrait;

    public int $cols = 5;

    public $translationModel = SectionTranslation::class;

    public $translationForeignKey = 'section_id';

    public array $translatedAttributes = ['name'];

    protected $casts = ['status' => Status::class];

    public array $fields = [
        ['name' => 'name', 'type' => 'text', 'trans' => 'back.form-name'],
    ];

    public function productsCount(): Attribute
    {
        return Attribute::get(fn() => $this->sectionProducts()->whereNull('type')->where('is_accepted', 1)->active()->count());
    }

    public function storeProductsCount(): Attribute
    {
        return Attribute::get(fn() => $this->sectionProducts()->whereNotNull('type')->where('is_accepted', 1)->active()->count());
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function sectionProducts(): HasMany
    {
        return $this->hasMany(Product::class)->with([
            'translation',
            'category.translation',
            'images',
        ]);
    }
}
