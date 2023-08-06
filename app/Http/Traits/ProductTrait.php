<?php

namespace App\Http\Traits;

use App\Enums\OrderStatus;
use App\Facade\Support\Core\{Crud, Uploaded};
use App\Facade\Support\Tools\Percentage;
use App\Http\Scopes\ProductScopes;
use App\Http\Traits\Api\ProductApi;
use App\Models\{Cart, CartProduct, Favorite, Option, Product, Provider, Spec, Token};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

trait ProductTrait
{
    use BasicTrait, ProductScopes, ProductApi;

    protected static function boot(): void
    {
        parent::boot();

        static::forceDeleting(fn($product) => storage_unlink_many('products', $product->images));
    }

    // attributes

    public function getFirstImageUrlAttribute(): string
    {
        return Uploaded::defaultImage($this->images->first()->image,'products');
    }

    public function getIsFaveAttribute(): bool
    {
        $user_id = auth()->guard('api')->user()->id ?? 0;

        $check = Favorite::whereProductId($this->id)->whereUserId($user_id)->count();

        return $check !== 0;
    }

    public function getCartQtyAttribute()
    {
        return CartProduct::query()
            ->whereCartId(request()->user()->cart->id ?? '0')
            ->whereProductId($this->id)
            ->select(['qty'])
            ->value('qty');
    }

    public function getOfferValueAttribute(): float
    {
        return floor(Percentage::total($this->offer, $this->price));
    }

    public function getOwnerNameAttribute(): string
    {
        if (is_null($this->type))
        {
            return "<span class='badge p-2 display-block text-dark f-12 badge-light-warning'>" . trans('back.rental') . '</span>';
        }

        $store_name = Provider::select(['store_name'])->where('id', $this->type_id)->value('store_name');

        return "<span class='badge p-2 display-block f-12 badge-light-dark'>" . ucwords($store_name) . '</span>';
    }

    public function getIsInCartAttribute(): bool
    {
        $is_in_cart = false;

        if (strlen(request()->header('authorization')) > 0)
        {
            $jwt = last(explode('Bearer ', request()->header('authorization')));

            $user = Token::whereJwt($jwt)->first();

            if (!$user) return false;

            $cart_id = Cart::whereUserId($user->tokenable_id)->value('id');

            $check = CartProduct::whereCartId($cart_id)->whereProductId($this->id)->count();

            $is_in_cart = $check > 0;
        }

        return $is_in_cart;
    }

    public function getOwnershipAttribute(): bool
    {
        return is_null($this->type);
    }

    // static helper methods

    public static function getInSelectForm(): array
    {
        return Crud::getModelsInSelectedForm(Product::class, 'name');
    }

    public static function getProvidersAddresses($products): array
    {
        $arr = [];

        if (!$products) return $arr;

        $ids = array_unique($products->pluck('type_id')->toArray());

        foreach (Provider::find($ids) as $provider)
        {
            $arr[] = ['address' => $provider->address, 'phone' => $provider->phone];
        }

        if (has_null($ids))
        {
            $arr[] = [
                'address' => optional(optional($products->first())->city)->address,
                'phone'   => optional(optional($products->first())->city)->phone,
            ];
        }

        return $arr;
    }

    public static function getAllOrderAddresses($order): array
    {
        $arr = self::getProvidersAddresses($order->products);

        if ($order->delivery_type == 'location') return $arr;

        return array(['address' => $order->addresses->first()->address, 'phone' => $order->addresses->first()->phone]);
    }

    public static function getRentedProducts(): array
    {
        $request = request();

        $query = Product::query();

        $query->join('order_product as op', 'op.product_id', '=', 'products.id');

        $query->join('orders', 'orders.id', '=', 'op.order_id');

        $query->select(['products.*']);

        $query->where('orders.status','!=',OrderStatus::PROCESSING)->distinct();

        if ($request->filled('startDate') && $request->filled('endDate')) {
            $query->where(function (Builder $que) use ($request) {
                $que->where('orders.start_date', $request->startDate . ' 00:00:00');
                $que->where('orders.end_date', $request->endDate . ' 00:00:00');
            });

            $query->orWhere(function (Builder $que) use ($request) { // before start_date
                $que->where('orders.start_date', '>', $request->startDate . ' 00:00:00');
                $que->where('orders.start_date', '<', $request->endDate . ' 00:00:00');
            });

            $query->orWhere(function (Builder $que) use ($request) { // between
                $que->where('orders.start_date', '<=', $request->startDate . ' 00:00:00');
                $que->where('orders.end_date', '>', $request->startDate . ' 00:00:00');
            });
        }

        return $query->get()->pluck('id')->toArray();
    }

    public function saveOptionsAndSpecs($options, $specs): void
    {
        $option_product_data = [];

        if($options)
        {
            foreach (Arr::wrap($options) as $i => $option_id) {
                $option_product_data[] = [
                    'product_id'      => $this->id,
                    'optionable_type' => Option::class,
                    'optionable_id'   => (int)$option_id,
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ];
            }
        }

        if($specs)
        {
            foreach (Arr::wrap($specs) as $spec_id => $value) {
                $option_product_data[] = [
                    'product_id'      => $this->id,
                    'optionable_type' => Spec::class,
                    'optionable_id'   => $spec_id,
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ];
            }
        }

        if(count($option_product_data) > 0) DB::table('option_products')->insert($option_product_data);
    }

    public function updateOptionsAndSpecs($options, $specs): void
    {
        DB::table('option_products')->where('product_id', $this->id)->delete();

        $this->saveOptionsAndSpecs($options, $specs);
    }
}
