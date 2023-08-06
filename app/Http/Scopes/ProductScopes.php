<?php

namespace App\Http\Scopes;

use App\Models\Provider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait ProductScopes
{
    public function scopeSearch(Builder $query, $term): Builder
    {
        $query->join('product_translations as pt', function ($join) {
            $join->on('products.id', '=', 'pt.product_id');
            $join->where('pt.locale', getLocale());
        });

        $query->select(['products.*']);

        $query->whereLike('pt.name', $term);
        $query->orWhereLike('products.price', $term);
        $query->orWhereLike('pt.description', $term);
        $query->orWhereLike('pt.rental_terms', $term);
        $query->orWhereLike('pt.usage_instructions', $term);

        return $query;
    }

    public function scopeRentalProducts(Builder $query): Builder
    {
        $query->where('status', 1);

        $query->whereNull('type');

        $query->has('category')->has('city');

        $query->where('is_accepted', 1);

        return $query;
    }

    public function scopeStoreProducts(Builder $query, $type_id = 0): Builder
    {
        $query->where('status', 1);

        $query->where('type', Provider::class);

        if ($type_id != 0) {
            $query->where('type_id', $type_id);
        }

        $query->where('is_accepted', 1);

        return $query;
    }

    public function scopeStoreProductsHasOffer(Builder $query, $type_id = 0): Builder
    {
        $query->storeProducts($type_id)->where('has_offer', 1);

        return $query;
    }

    public function scopeSimilar(Builder $query, $product): Builder
    {
        $query->where('id', '!=', $product->id);

        if ($product) {
            $query->where('category_id', $product->category_id);

            if ($product->type_id) {
                $query->where('type', $product->type);

                $query->where('type_id', $product->type_id);
            }

            $query->orWhere('section_id', $product->section_id);
        }

        return $query;
    }

    public function scopeWhenStoreIs(Builder $query, $type_id): Builder
    {
        $query->where('type', Provider::class)->where('type_id', $type_id);

        return $query;
    }

    public function scopeWhenStoreExists(Builder $query, $request): Builder
    {
        $query->when($request, function ($q, $request) {
            if ($request->store_id) {
                $q->storeProducts($request->store_id);
            }
        });

        $query->when($request, function ($q, $request) {
            if (!$request->store_id) {
                $q->rentalProducts();
            }
        });

        return $query;
    }

    public function scopePopular(Builder $query): Builder
    {
        return $query->whereHas('orders', function ($q) {
            $q->whereNull('type')
                ->whereNull('type_id')
                ->select('product_id', DB::raw('count(product_id) as count'))
                ->groupBy('product_id')
                ->having('count', '>', 1);
        });
    }

    public function scopeOnlyActiveSections(Builder $query): Builder
    {
        return $query->whereHas('section', fn($q) => $q->where('status', 1));
    }

    public function scopeWithRelations(Builder $query): Builder
    {
        return $query->with(['translation', 'images', 'section.translation', 'category.translation']);
    }
}
