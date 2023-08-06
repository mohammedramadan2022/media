<?php

namespace App\Http\Traits;

use App\Http\Scopes\AdminScopes;
use App\Http\Traits\Api\AdminApi;
use App\Models\Role;

trait AdminTrait
{
    use BasicTrait, AdminScopes, AdminApi;

    protected static function boot(): void
    {
        parent::boot();

        static::forceDeleting(fn ($admin) => storage_unlink('admins', $admin?->image?->image));
    }

    public static function getProviders(): array
    {
        $providers = [];

        $role = Role::find(5);

        foreach ($role->admins as $admin)
        {
            $providers[$admin->id] = $admin->name;
        }

        return $providers;
    }
}
