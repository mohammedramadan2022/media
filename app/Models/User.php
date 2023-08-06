<?php

namespace App\Models;

use App\Casts\Status;
use App\Facade\Support\Core\Uploaded;
use App\Http\Traits\Other\{HasFcm, HasJwt, HasWallet, Imageable, Blockable};
use App\Http\Traits\UserTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany, HasOne, MorphMany};
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, UserTrait, SoftDeletes, Blockable, HasJwt, HasFcm, HasWallet, Imageable;

    public string $guard = 'api';

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'status'            => Status::class,
        'password'          => 'hashed',
    ];

    protected $appends = ['image_url'];

    public function identityImageUrl(): Attribute
    {
        return Attribute::get(fn() => Uploaded::defaultImage($this->identity,'identities'));
    }

    public function fullName(): Attribute
    {
        return Attribute::get(fn() => "$this->first_name $this->last_name");
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function notifications(): MorphMany
    {
        return $this->morphMany(Notification::class,'notificationable');
    }

    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
