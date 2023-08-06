<?php

namespace App\Repository\Eloquent\Sql;

use App\Enums\OrderStatus;
use App\Facade\Support\Tools\CrudMessage;
use App\Models\Notification;
use App\Models\Throwback;
use App\Repository\Contracts\IThrowbackRepository;
use Illuminate\Http\RedirectResponse;

class ThrowbackRepository extends BaseRepository implements IThrowbackRepository
{
    public function __construct(Throwback $model)
    {
        parent::__construct($model);
    }

    public function accept(Throwback $throwback): RedirectResponse
    {
        $throwback->update(['status' => 1]);

        $throwback->order()->update(['status' => OrderStatus::RETURNS]);

        Notification::sendUserThrowbackDemandAccepted($throwback);

        return CrudMessage::success();
    }

    public function refuse(Throwback $throwback): RedirectResponse
    {
        $throwback->update(['status' => 0]);

        Notification::sendUserThrowbackDemandRefused($throwback);

        return CrudMessage::success();
    }
}
