<?php

namespace App\Models;

use App\Casts\Status;
use App\Http\Traits\RoleTrait;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use SoftDeletes, Translatable, RoleTrait;

    public int $cols = 5;

    public $translationModel = RoleTranslation::class;

    public $translationForeignKey = 'role_id';

    public array $translatedAttributes = ['name'];

    public array $fields = [
        ['name' => 'name', 'type' => 'text', 'trans' => 'back.form-name'],
    ];

    protected $casts = ['status' => Status::class];

    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class);
    }

    public function admins(): HasMany
    {
        return $this->hasMany(Admin::class);
    }
}
