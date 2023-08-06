<?php

namespace App\Models;

use App\Casts\Status;
use App\Http\Traits\BannerTrait;
use App\Http\Traits\Other\HasImage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Banner extends Model
{
    use SoftDeletes, BannerTrait, HasImage;

    public int $cols = 5;

    protected $guarded = ['id'];

    protected $casts = ['status' => Status::class];

    public function bannerUrl(): Attribute
    {
        return Attribute::get(function () {
            return match ($this->type) {
                'product' => route('front.show-product', Product::select('slug')->find($this->type_id)->slug),
                'section' => route('front.show-section', Section::select('slug')->find($this->type_id)->slug),
                'link'    => url($this->type_id),
                default   => 'javascript:void(0);'
            };
        });
    }
}
