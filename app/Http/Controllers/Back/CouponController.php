<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\RepoController;
use App\Http\Requests\Back\{CreateCouponRequest, EditCouponRequest};
use App\Models\Coupon;
use App\Repository\Contracts\ICouponRepository;

class CouponController extends RepoController
{
    public function __construct(ICouponRepository $repository)
    {
        parent::__construct($repository);
    }

    public function store(CreateCouponRequest $request)
    {
        return self::repo()->store($request);
    }

    public function update(EditCouponRequest $request, Coupon $coupon)
    {
        return self::repo()->update($request, $coupon);
    }
}
