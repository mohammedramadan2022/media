<?php

namespace App\Http\Traits\Other;

use App\Facade\Support\Core\Uploaded;
use App\Models\Image;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait Imageable
{
    public function imageUrl(): Attribute
    {
        return Attribute::get(fn() => Uploaded::defaultImage($this->image()->first(), $this->getTable()));
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
