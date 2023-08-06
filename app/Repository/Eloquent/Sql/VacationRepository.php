<?php

namespace App\Repository\Eloquent\Sql;

use App\Facade\Support\Tools\CrudMessage;
use App\Models\{Notification, Vacation};
use App\Repository\Contracts\IVacationRepository;
use Illuminate\Http\RedirectResponse;

class VacationRepository extends BaseRepository implements IVacationRepository
{
    public function __construct(Vacation $model)
    {
        parent::__construct($model);
    }

    public function accept(Vacation $vacation): RedirectResponse
    {
        $vacation->update(['is_accepted' => true, 'acceptor_id' => request()->user()->id]);

        Notification::sendEmployeeAcceptVacationDemand($vacation);

        return CrudMessage::success();
    }

    public function refuse(Vacation $vacation): RedirectResponse
    {
        $vacation->update(['is_accepted' => false, 'acceptor_id' => request()->user()->id]);

        Notification::sendEmployeeRefuseVacationDemand($vacation);

        return CrudMessage::success();
    }
}
