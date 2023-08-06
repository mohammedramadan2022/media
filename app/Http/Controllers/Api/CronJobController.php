<?php

namespace App\Http\Controllers\Api;

use App\Enums\OrderStatus;
use App\Enums\PaymentEnum;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;

class CronJobController extends Controller
{
    public function gitPull(): Response
    {
        Artisan::call('git:pull');

        Artisan::call('optimize:clear');

        return response()->noContent();
    }

    public function setOrderToBeRetrieving(): JsonResponse
    {
        foreach (Order::delivered()->get() as $order) {
            if (! $order->end_date->isPast() || $order->status == OrderStatus::RETRIEVING) {
                continue;
            }

            if ($order->delayed_days != 0) {
                $order->update([
                    'delay_penalty' => $order->delayed_days * $order->price,
                    'payment_status' => PaymentEnum::OWES_A_DELAY,
                ]);
            }

            if ($order->end_date->isPast()) {
                $order->update(['status' => OrderStatus::RETRIEVING]);
            }
        }

        return response()->json(['status' => true]);
    }
}
