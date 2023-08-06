<?php

namespace App\Models;

use App\Casts\Status;
use App\Facade\Support\Core\Uploaded;
use App\Http\Traits\{HasIsRated, ProviderTrait};
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, MorphMany, BelongsToMany, HasMany};
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as AuthenticatableProvider;

class Provider extends AuthenticatableProvider
{
    use SoftDeletes, ProviderTrait, HasIsRated;

    public int $cols = 5;

    public string $guard = 'provider';

    protected $guarded = ['id'];

    protected $with = ['demand'];

    protected $casts = ['status' => Status::class, 'password' => 'hashed'];

    public function logoUrl(): Attribute
    {
        return Attribute::get(fn () => Uploaded::defaultImage($this->logo,'demands'));
    }

    public function demand(): BelongsTo
    {
        return $this->belongsTo(Demand::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function rates(): MorphMany
    {
        return $this->morphMany(Rate::class, 'rateable');
    }

    public function orders(): BelongsToMany
    {
        return $this
            ->belongsToMany(Order::class,'order_provider')
            ->withPivot([
                'provider_order_price', 'provider_order_tax', 'provider_order_subtotal',
                'provider_order_discount', 'provider_order_total', 'provider_order_total_insurance',
                'is_accepted',
            ]);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class,'type_id','id')->where('type',Provider::class);
    }
}
