<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\RepoController;
use App\Http\Requests\Back\{CreateRoleRequest, EditRoleRequest};
use App\Models\Role;
use App\Repository\Contracts\IRoleRepository;

class RoleController extends RepoController
{
    public function __construct(IRoleRepository $repository)
    {
        parent::__construct($repository);
    }

    public function store(CreateRoleRequest $request)
    {
        return self::repo()->store($request);
    }

    public function update(EditRoleRequest $request, Role $role)
    {
        return self::repo()->update($request, $role);
    }
}
