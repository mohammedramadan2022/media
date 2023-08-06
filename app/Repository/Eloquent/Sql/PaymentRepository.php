<?php

namespace App\Repository\Eloquent\Sql;

use App\Models\Payment;
use App\Repository\Contracts\IPaymentRepository;

class PaymentRepository extends BaseRepository implements IPaymentRepository
{
    public function __construct(Payment $model)
    {
        $this->model = $model;

        parent::__construct($model);
    }
}
