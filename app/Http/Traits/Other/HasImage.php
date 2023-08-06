<?php

namespace App\Http\Traits\Other;

use App\Facade\Support\Core\Uploaded;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasImage
{
    public function imageUrl(): Attribute
    {
        return Attribute::get(fn() => Uploaded::defaultImage($this->image, $this->getTable()));
    }

}
