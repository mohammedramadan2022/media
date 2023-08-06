<?php

namespace App\Repository\Eloquent\Sql;

use App\Facade\Support\Core\Crud;
use App\Facade\Support\Tools\CrudMessage;
use App\Models\Role;
use App\Repository\Contracts\IRoleRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RoleRepository extends BaseRepository implements IRoleRepository
{
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    public function index()
    {
        return view('Back.Roles.index', [
            'roles' => $this->model::query()->whereNotIn('id', [1, 3, 4, 5, 6])->withTranslation()->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $roleData = $request->except(['_token', '_method']);

            $roleData['status'] = $request->has('status') ? $request->status : false;

            $formTranslatedAttrs = arr()->only($roleData, array_keys(sitelangs()));

            $roleData = arr()->except($roleData, array_keys(sitelangs()));

            $role = Role::create(except($roleData, ['_token', 'permissions']));

            Crud::saveTranslatedAttrs($role, $formTranslatedAttrs);

            $role->save();

            DB::table('permissions')->insert(Role::setPermissions($request, $role));

            DB::commit();

            return CrudMessage::add('permission');
        } catch (Exception $e) {
            DB::rollBack();

            return CrudMessage::fails($e);
        }
    }

    public function update(Request $request, $currentModel)
    {
        DB::beginTransaction();
        try
        {
            $permissions = Role::setPermissions($request, $currentModel);

            [$modelData, $formTranslatedAttrs] = Crud::explode($request->except('permissions'));

            Crud::saveTranslatedAttrs($currentModel, $formTranslatedAttrs, $modelData);

            $currentModel->save();

            DB::table('permissions')->where('role_id', $currentModel->id)->delete();

            DB::table('permissions')->insert($permissions);

            DB::commit();

            return CrudMessage::edit('permission');
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return CrudMessage::fails($e);
        }
    }

    public function create(): View
    {
        return view('Back.Crud.create', self::formFields());
    }

    public function edit($id)
    {
        if ($id == 1) {
            return redirect()->route('roles.index');
        }

        $currentModel = $this->model::findOrFail($id);

        Crud::load_translated_attrs($currentModel);

        return view('Back.Crud.edit', self::formFields('edit', $currentModel));
    }
}
