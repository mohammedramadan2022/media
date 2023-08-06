<?php

namespace App\Http\Traits\Api;

use App\Facade\Support\Core\ApiResponse;
use App\Http\Resources\User\VacationResource;
use App\Models\Vacation;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

trait VacationApi
{
    public static function apiSetEmployeeVacationDemand($request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            Vacation::updateOrCreate($request->validated() + ['admin_id' => $request->user()->id]);

            DB::commit();

            return ApiResponse::success();
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return ApiResponse::fails($e);
        }
    }

    public static function apiGetEmployeeVacationDemands($request): JsonResponse
    {
        $vacations = Vacation::with('admin')->where('admin_id', $request->user()->id)->paginate(10);

        return ApiResponse::pagination($vacations, VacationResource::class);
    }
}
