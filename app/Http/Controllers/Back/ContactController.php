<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\RepoController;
use App\Http\Requests\Back\SendUserReplayMessageRequest;
use App\Repository\Contracts\IContactRepository;
use Illuminate\Http\Request;

class ContactController extends RepoController
{
    public function __construct(IContactRepository $repository)
    {
        parent::__construct($repository);
    }

    public function contacts()
    {
        return self::repo()->contacts();
    }

    public function showMessageDetails($id)
    {
        return self::repo()->showMessageDetails($id);
    }

    public function sendUserMessage($id)
    {
        return self::repo()->sendUserMessage($id);
    }

    public function deleteMessage(Request $request)
    {
        return self::repo()->deleteMessage($request);
    }

    public function sendUserReplayMessage(SendUserReplayMessageRequest $request)
    {
        return self::repo()->sendUserReplayMessage($request);
    }
}
