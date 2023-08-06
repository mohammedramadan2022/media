<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\RepoController;
use App\Repository\Contracts\IPaymentRepository;

class PaymentController extends RepoController
{
    public function __construct(IPaymentRepository $repository)
    {
        parent::__construct($repository);
    }
}
