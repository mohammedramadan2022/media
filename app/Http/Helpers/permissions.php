<?php

use App\Enums\RoleEnum;
use Illuminate\Support\Facades\Route;

function permission_checker($auth): bool
{
    if ($auth->role->id == RoleEnum::SUPPER_ADMIN) return true;

    foreach ($auth->role->permissions as $permission) {
        if (request()->route()->getName() != $permission->permission) continue;

        return true;
    }

    return false;
}

function permission_route_checker($route): bool
{
    $auth = request()->user();

    if ($auth->role->id == RoleEnum::SUPPER_ADMIN) return true;

    foreach ($auth->role->permissions as $permission) {
        if ($route != $permission->permission) continue;

        return true;
    }

    return false;
}

function has_permission(...$routes): bool
{
    $res = [];

    foreach ($routes as $route) {
        $res[] = permission_route_checker($route);
    }

    return in_array(true, $res);
}

function edit_permissions($permissions, $check): string
{
    return in_array($check, $permissions->pluck('permission')->toArray()) ? 'checked' : '';
}

function getAllRoutes(): array
{
    // this function control everything in permissions page routes
    $routes = Route::getRoutes();

    $arr = [];

    foreach ($routes as $key => $value) {
        if ($value->getName() !== null && ! in_array($value->getName(), not_in_routes())) {
            $action = $value->getAction();

            if (str($action['as'])->contains(['debugbar', 'sanctum', 'ignition', 'livewire', 'front', 'pdfview', 'not-found'])) {
                continue;
            }

            if ($action['namespace'] === 'Auth' || $action['namespace'] === 'Provider') {
                continue;
            }

            if ($action['prefix'] === 'provider-panel') {
                continue;
            }

            if (count(explode('/', $action['prefix'])) > 1) {
                continue;
            }

            $route = str($action['as'])->explode('.')->toArray();

            if (count($route) >= 2) {
                $arr[$route[0]][$key] = $action['as'];
            } else {
                $arr[$key] = $action['as'];
            }
        }
    }

    return $arr;
}

function not_in_routes(): array
{
    return [
        'home',
        'migrator.read',
        'login',
    ];
}

function creatRouteNotIn(): array
{
    return ['commission', 'payment', 'order', 'vote', 'transaction', 'upload', 'subscription', 'demand'];
}

function trashedRouteNotIn(): array
{
    return ['notification', 'demand', 'vote'];
}

function set_permissions_rows($count): string
{
    return match ($count) {
        $count <= 20 => 'col-md-12',
        $count <= 40 => 'col-md-6',
        $count <= 60 => 'col-md-4',
        $count <= 80 => 'col-md-3',
        $count <= 100 => 'col-md-2',
        default => 'col-md-1',
    };
}
