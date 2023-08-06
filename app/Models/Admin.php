<?php

namespace App\Models;

use App\Casts\Status;
use App\Enums\RoleEnum;
use App\Http\Traits\AdminTrait;
use App\Http\Traits\Other\{HasFcm, HasJwt, Imageable};
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, MorphMany, HasMany, HasOne};
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as AuthenticatableAdmin;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Admin extends AuthenticatableAdmin implements JWTSubject
{
    use HasFactory, Notifiable, SoftDeletes, AdminTrait, HasJwt, HasFcm, Imageable;

    public string $guard = 'admin';

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['status' => Status::class, 'password' => 'hashed'];

    public function roleName(): Attribute
    {
        return Attribute::get(fn () => match ($this->role_id) {
            RoleEnum::SUPPER_ADMIN      => 'super_admin',
            RoleEnum::CEO               => 'ceo',
            RoleEnum::ORDERS_OFFICER    => 'orders_officer',
            RoleEnum::DELIVERY_OFFICER  => 'delivery_officer',
            RoleEnum::DELIVERY_PROVIDER => 'delivery_representative',
            RoleEnum::WAREHOUSE_OFFICER => 'warehouse_officer',
        });
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class)->withDefault(['name' => trans('back.no-value')]);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function advances(): HasMany
    {
        return $this->hasMany(Advance::class);
    }

    public function vacations(): HasMany
    {
        return $this->hasMany(Vacation::class);
    }

    public function notifications(): MorphMany
    {
        return $this->morphMany(Notification::class,'notificationable');
    }

    public function logger(): HasMany
    {
        return $this->hasMany(AdminOrder::class,'admin_id','id');
    }

    public function adminStatus(): HasOne
    {
        return $this->hasOne(AdminStatus::class);
    }
}
