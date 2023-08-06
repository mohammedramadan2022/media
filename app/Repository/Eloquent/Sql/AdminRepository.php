<?php

namespace App\Repository\Eloquent\Sql;

use App\Facade\Support\Core\{Crud, Warning, Firebase};
use App\Facade\Support\Tools\CrudMessage;
use App\Models\{Admin, Role, Contact};
use App\Repository\Contracts\IAdminRepository;
use Illuminate\Http\{RedirectResponse, Request};

class AdminRepository extends BaseRepository implements IAdminRepository
{
    public function __construct(Admin $model)
    {
        parent::__construct($model);
    }

    public function index()
    {
        return view('Back.Admins.index', [
            'admins' => $this->model::where('role_id', '!=', 1)->has('role')->with(['role', 'role.translation'])->latest()->paginate(10),
        ]);
    }

    public function update(Request $request, $currentModel)
    {
        $adminData = $request->except(['password', '_token', 'password_confirmation', '_method']);

        if ($request->password) $adminData['password'] = $request->password;

        return Crud::update($this->class, $adminData, $currentModel);
    }

    public function showAdminMessage($id): string
    {
        if (! $admin = Admin::find($id)) return Warning::adminIsNotFound();

        return view('Back.Admins.showAdminMailSendModal', compact('admin'))->render();
    }

    public function sendAdminMessage(Request $request): RedirectResponse
    {
        return Contact::sendEmail($request);
    }

    public function adminProfile()
    {
        return view('Back.Admins.profile', ['admin' => admin()]);
    }

    public function updateAdminProfile(Request $request)
    {
        $adminData = $request->except(['password', '_token', 'password_confirmation', '_method']);

        $adminData['status'] = admin('status') ?? null;

        if ($request->password) $adminData['password'] = $request->password;

        return Crud::update($this->class, $adminData, admin());
    }

    public function formFields($type = 'create', $currentModel = null): array
    {
        $data = parent::formFields($type, $currentModel);

        $data['roles'] = Role::getInSelectForm();

        return $data;
    }

    public function sendAdminNotification(Request $request): RedirectResponse
    {
        $admin = $this->find($request->admin_id);

        if (! $admin->fcm_token) return CrudMessage::error('Admin has no fcm token');

        $response = Firebase::push($request->title, $request->body, $admin);

        if (! $response->status) return CrudMessage::error('Firebase Exception : '.$response->message);

        return CrudMessage::success();
    }
}
