<?php

namespace App\Models;

use App\Facade\Support\Tools\Time;
use App\Enums\{OrderStatus, PaymentEnum};
use App\Http\Traits\OrderTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\{BelongsTo, MorphOne, BelongsToMany, HasMany, HasOne};

class Order extends Model
{
    use SoftDeletes, OrderTrait;

    public int $cols = 5;

    protected $guarded = ['id'];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'start_time' => 'datetime',
        'end_time'   => 'datetime',
    ];

    protected $appends = ['is_payed', 'rental_products_count'];

    public function rentalProductsCount(): Attribute
    {
        return Attribute::get(function() {
            return OrderProduct::query()->whereNull('type')->where('order_id', $this->id)->count();
        });
    }

    public function rentalProducts(): Attribute
    {
        return Attribute::get(function() {
            return OrderProduct::query()->whereNull('type')->where('order_id', $this->id)->get();
        });
    }

    public function isPayed(): Attribute
    {
        return Attribute::get(function() {
            return !is_null($this->payment_id) && $this->payment_status != PaymentEnum::DELAYED && !is_null($this->payment_method);
        });
    }

    public function storeProductsCount(): Attribute
    {
        return Attribute::get(function() {
            return OrderProduct::query()->whereNotNull('type')->whereOrderId($this->id)->count();
        });
    }

    public function delayedDays(): Attribute
    {
        return Attribute::get(function() {
            return $this->end_date->isPast() && $this->status != OrderStatus::RECEIVED
                ? $this->end_date->diffInDays(now())
                : '0';
        });
    }

    public function invoiceUrl(): Attribute
    {
        return Attribute::get(fn() => route('admin.pdfview', ['order_id' => base64_encode($this->id)]));
    }

    public function userOrderAddress(): Attribute
    {
        return Attribute::get(function() {
            return $this
                ->addresses()
                ->where('addressable_type', User::class)
                ->where('addressable_id', $this->user_id)
                ->first();
        });
    }

    public function startTime(): Attribute
    {
        return Attribute::set(fn($value) => Time::create24Format($value));
    }

    public function endTime(): Attribute
    {
        return Attribute::set(fn($value) => Time::create24Format($value));
    }

    public function isAllAccept(): Attribute
    {
        return Attribute::get(function() {
            $acceptors = count($this->providers()->where('is_accepted', 1)->pluck('is_accepted')->toArray());

            $providers = $this->providers()->count();

            if ($providers == 0) return false;

            return $providers === $acceptors;
        });
    }

    public function walletStatus(): Attribute
    {
        return Attribute::get(fn() => request()->user()->is_wallet_empty ? trans('back.no-enough-balance') : '');
    }

    public function rentingDays(): Attribute
    {
        return Attribute::get(fn() => $this->start_date->diffInDays($this->end_date));
    }

    public function rentingHours(): Attribute
    {
        return Attribute::get(function() {
            $startTimeDate = Time::createFullDatetime($this->start_date->format('Y-m-d'), $this->start_time->format('H:i'));

            $endTimeDate = Time::createFullDatetime($this->end_date->format('Y-m-d'), $this->end_time->format('H:i'));

            return $endTimeDate->diffInHours($startTimeDate);
        });
    }

    public function rentingType(): Attribute
    {
        return Attribute::get(fn() => $this->start_date->diffInDays($this->end_date) == 0 ? 'hour' : 'day');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payment(): MorphOne
    {
        return $this->morphOne(Payment::class, 'paymentable');
    }

    public function providers(): BelongsToMany
    {
        return $this
            ->belongsToMany(Provider::class, 'order_provider')
            ->withPivot([
                'is_accepted', 'order_id',
            ]);
    }

    public function products(): BelongsToMany
    {
        return $this
            ->belongsToMany(Product::class, 'order_product')
            ->withPivot([
                'product_name', 'product_price', 'product_image',
                'product_qty', 'product_section', 'product_section_icon',
                'product_rate', 'product_rates_count', 'product_offer',
                'product_city_name', 'product_category',
            ])
            ->with(['translation', 'images', 'city.translation', 'section.translation', 'category.translation'])
            ->withTrashed();
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(OrderAddress::class);
    }

    public function loggers(): HasMany
    {
        return $this->hasMany(AdminOrder::class, 'order_id', 'id');
    }

    public function reason(): HasOne
    {
        return $this->hasOne(Reason::class);
    }
}
