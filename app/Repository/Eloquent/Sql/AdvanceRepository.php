<?php

namespace App\Repository\Eloquent\Sql;

use App\Facade\Support\Tools\CrudMessage;
use App\Models\Advance;
use App\Models\Notification;
use App\Repository\Contracts\IAdvanceRepository;
use Illuminate\Http\RedirectResponse;

class AdvanceRepository extends BaseRepository implements IAdvanceRepository
{
    public function __construct(Advance $model)
    {
        parent::__construct($model);
    }

    public function accept(Advance $advance): RedirectResponse
    {
        $advance->update(['is_accepted' => true, 'acceptor_id' => request()->user()->id]);

        Notification::sendEmployeeAcceptAdvanceDemand($advance);

        return CrudMessage::success();
    }

    public function refuse(Advance $advance): RedirectResponse
    {
        $advance->update(['is_accepted' => false, 'acceptor_id' => request()->user()->id]);

        Notification::sendEmployeeRefuseAdvanceDemand($advance);

        return CrudMessage::success();
    }
}
