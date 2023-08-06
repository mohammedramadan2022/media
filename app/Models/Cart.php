<?php

namespace App\Models;

use App\Casts\Status;
use App\Http\Traits\ShoppingCartTrait;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cart extends Model
{
    use SoftDeletes, ShoppingCartTrait;

    public int $cols = 5;

    protected $casts = ['status' => Status::class];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'cart_product')->withPivot('qty', 'price');
    }
}
