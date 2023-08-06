<?php

namespace App\Repository\Eloquent\Sql;

use App\Facade\Support\Core\Crud;
use App\Models\{Admin, Coupon};
use App\Repository\Contracts\ICouponRepository;
use Illuminate\Http\Request;

class CouponRepository extends BaseRepository implements ICouponRepository
{
    public function __construct(Coupon $model)
    {
        parent::__construct($model);
    }

    public function store(Request $request)
    {
        $modelData = $request->all();

        $modelData['couponable_type'] = Admin::class;

        $modelData['couponable_id'] = $request->user()->id;

        return Crud::store($this->class, $modelData);
    }
}
