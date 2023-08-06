<?php

namespace App\Models;

use App\Casts\Status;
use App\Http\Traits\HasIsRated;
use App\Http\Traits\ProductTrait;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\{BelongsTo, MorphMany, HasMany};

class Product extends Model
{
    use SoftDeletes, Translatable, ProductTrait, HasIsRated;

    public int $cols = 5;

    public $translationModel = ProductTranslation::class;

    public $translationForeignKey = 'product_id';

    public array $translatedAttributes = ['name', 'description', 'rental_terms', 'usage_instructions'];

    protected $casts = ['status' => Status::class];

    protected $appends = ['ownership'];

    public array $fields = [
        ['name' => 'name', 'type' => 'text', 'trans' => 'back.form-name'],
        ['name' => 'description', 'type' => 'ckeditor', 'trans' => 'back.form-description'],
        ['name' => 'rental_terms', 'type' => 'ckeditor', 'trans' => 'back.form-rental-terms'],
        ['name' => 'usage_instructions', 'type' => 'ckeditor', 'trans' => 'back.form-usage-instructions'],
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class, 'type_id');
    }

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function rates(): MorphMany
    {
        return $this->morphMany(Rate::class, 'rateable');
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function options(): HasMany
    {
        return $this->hasMany(OptionProduct::class)->where('optionable_type', Option::class);
    }

    public function specs(): hasMany
    {
        return $this->hasMany(OptionProduct::class)->where('optionable_type', Spec::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }
}
