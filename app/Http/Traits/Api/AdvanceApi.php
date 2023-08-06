<?php

namespace App\Http\Traits\Api;

use App\Facade\Support\Core\ApiResponse;
use App\Http\Resources\Employee\AdvanceResource;
use App\Models\Advance;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

trait AdvanceApi
{
    public static function apiSetEmployeeAdvanceDemand($request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            $data = $request->validated() + ['admin_id' => $request->user()->id];

            Advance::updateOrCreate($data);

            DB::commit();

            return ApiResponse::success();
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return ApiResponse::fails($e);
        }
    }

    public static function apiGetEmployeeAdvanceDemands($request): JsonResponse
    {
        $advances = Advance::with('admin')->where('admin_id', $request->user()->id)->get();

        return ApiResponse::response(AdvanceResource::collection($advances));
    }
}
