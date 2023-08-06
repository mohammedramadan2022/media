<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\RepoController;
use App\Models\Throwback;
use App\Repository\Contracts\IThrowbackRepository;

class ThrowbackController extends RepoController
{
    public function __construct(IThrowbackRepository $repository)
    {
        parent::__construct($repository);
    }

    public function accept(Throwback $throwback)
    {
        return self::repo()->accept($throwback);
    }

    public function refuse(Throwback $throwback)
    {
        return self::repo()->refuse($throwback);
    }
}
