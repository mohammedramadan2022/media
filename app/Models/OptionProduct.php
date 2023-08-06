<?php

namespace App\Models;

use App\Http\Traits\BasicTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, MorphTo};

class OptionProduct extends Model
{
    use BasicTrait;

    protected $guarded = ['id'];

    public function optionable(): MorphTo
    {
        return $this->morphTo();
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public static function getProductsBySpecsAndOptions($ids): array
    {
        $query = self::query();

        $query->join('products','products.id','=','option_products.product_id');

        $query->select(['option_products.*']);

        if (request('belongs_to') == 'rental') {
            $query->whereNull('type');
        } else {
            $query->whereNotNull('type');
        }

        $query->whereIn('optionable_id', $ids);

        $query->select(['product_id']);

        return $query->get()->pluck('product_id')->toArray();
    }
}
