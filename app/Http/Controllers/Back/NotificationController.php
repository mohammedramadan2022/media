<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\RepoController;
use App\Http\Requests\Back\SendNotificationRequest;
use App\Repository\Contracts\INotificationRepository;
use Illuminate\Http\Request;

class NotificationController extends RepoController
{
    public function __construct(INotificationRepository $repository)
    {
        parent::__construct($repository);
    }

    public function store(SendNotificationRequest $request)
    {
        return self::repo()->store($request);
    }

    public function getListByType(Request $request)
    {
        return self::repo()->getListByType($request);
    }
}
