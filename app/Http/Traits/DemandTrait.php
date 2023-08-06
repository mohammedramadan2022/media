<?php

namespace App\Http\Traits;

use App\Http\Scopes\DemandScopes;
use App\Http\Traits\Api\DemandApi;
use App\Mail\SendAdminMail;
use Illuminate\Support\Facades\Mail;

trait DemandTrait
{
    use BasicTrait, DemandScopes, DemandApi;

    public static function sendReviewMail($demand): void
    {
        $message = 'تم ارسال طلبكم بالانضمام لرينتال سيتم مراجعة البيانات المقدمة في الطلب وفي حالة الموافقة علي الطلب سيتم تأكيد قبول الطلب بإرسال رسالة بريد إلكتروني تفيد بالموافقة علي الطلب';

        Mail::to($demand->email)->send(new SendAdminMail($message, 'طلب الانضمام لدي رينتال'));
    }
}
