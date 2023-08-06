<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\PARENT_API;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PaymentController extends PARENT_API
{
    public function walletSuccess(Request $request): string
    {
        return Payment::walletSuccess($request);
    }

    public function walletWebSuccess(Request $request): RedirectResponse
    {
        return Payment::walletWebSuccess($request);
    }

    public function paySuccess(Request $request): string
    {
        return Payment::paySuccess($request);
    }

    public function payDelaySuccess(Request $request): string
    {
        return Payment::payDelaySuccess($request);
    }

    public function payDelayWebSuccess(Request $request): string
    {
        return Payment::payDelayWebSuccess($request);
    }

    public function payWebSuccess(Request $request): RedirectResponse
    {
        return Payment::payWebSuccess($request);
    }

    public function payInsuranceSuccess(Request $request): string
    {
        return Payment::payInsuranceSuccess($request);
    }

    public function payInsuranceWebSuccess(Request $request): RedirectResponse
    {
        return Payment::payInsuranceWebSuccess($request);
    }
}
