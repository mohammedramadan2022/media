<?php

namespace App\Http\Traits;

use App\Http\Scopes\RoleScopes;
use App\Models\Role;

trait RoleTrait
{
    use BasicTrait, RoleScopes;

    public static function setPermissions($request, $role): array
    {
        $permissions = [];

        $homePage[0] = self::setGeneralPermissions($role, 'admin-panel');

        $homePage[1] = self::setGeneralPermissions($role, 'search');

        foreach ($request->permissions as $key => $permission) {
            if ($permission == null) {
                continue;
            }

            $permissions[$key]['role_id'] = $role->id;
            $permissions[$key]['permission'] = $permission;
            $permissions[$key]['created_at'] = now();
            $permissions[$key]['updated_at'] = now();
        }

        return array_merge($permissions, $homePage);
    }

    public static function getInSelectForm($exceptedIds = []): array
    {
        $roles = [];

        $rolesDB = Role::withTranslation()->whereNotIn('id', $exceptedIds)->where('id', '!=', 1)->get();

        foreach ($rolesDB as $role) {
            $roles[$role->id] = ucwords($role->name);
        }

        return $roles;
    }

    private static function setGeneralPermissions($role, $permission): array
    {
        return [
            'role_id' => $role->id,
            'permission' => $permission,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
