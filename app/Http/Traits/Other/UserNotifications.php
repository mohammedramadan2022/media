<?php

namespace App\Http\Traits\Other;

use App\Facade\Support\Core\Firebase;
use App\Models\Order;
use Illuminate\Support\Str;

trait UserNotifications
{
    public static function sendUserOrderPayedOnlineSuccessfully($order): void
    {
        $subject = 'تم دفع قيمة الطلب رقم # ؟ بنجاح وتحويل الطلب الخاص بك الي طلب جاري العمل عليه';

        $message = Str::replaceArray('؟', [$order->order_no], $subject);

        Firebase::combine('الطلبات', $message, $order->user, 'user_order_payed', $order->order_no);
    }

    public static function sendUserOrderReadyToPay($order): object
    {
        $subject = 'تم قبول طلبك بنجاح. يمكنك الأن دفع مستحقات الطلب الخاص بك رقم ؟ من تفاصيل الطلب';

        $message = Str::replaceArray('؟', [$order->order_no], $subject);

        return Firebase::combine('الطلبات', $message, $order->user, 'user_order_ready_to_pay', $order->order_no);
    }

    public static function sendUserOrderRejected($order): void
    {
        $subject = 'تم رفض طلبك المقدم بتاريخ ؟ من قبل إدارة الموقع برجاء التواصل لمعرفه الأسباب';

        $message = Str::replaceArray('؟', [$order->created_at->format('Y-m-d')], $subject);

        Firebase::combine('الطلبات', $message, $order->user, 'user_order_rejected', $order->order_no);
    }

    public static function sendCashPaid($order): void
    {
        $subject = 'تم تأكيد دفع إجمالي الطلب الخاص بك رقم ؟ نقدا عند الاستلام بنجاح';

        $message = Str::replaceArray('؟', [$order->order_no], $subject);

        Firebase::combine('الطلبات', $message, $order->user, 'user_order_paid_cash', $order->order_no);
    }

    public static function sendUserOrderPending($order): void
    {
        $message = Str::replaceArray('؟', [$order->order_no], 'تم تحويل طلبك رقم ؟ الي قيد المراجعة');

        Firebase::combine('الطلبات', $message, $order->user, 'user_order_pending', $order->order_no);
    }

    public static function sendUserOrderCanceled($order): void
    {
        $subject = 'تم تحويل طلب رقم ؟ الي طلب ملغي من قبل الإدارة برجاء التواصل لمزيد من المعلومات';

        $message = Str::replaceArray('؟', [$order->order_no], $subject);

        Firebase::combine('الطلبات', $message, $order->user, 'user_order_canceled', $order->order_no);
    }

    public static function sendUserOrderProcessing($order): void
    {
        $message = Str::replaceArray('؟', [$order->order_no], 'تم تحويل الطلب الخاص بك رقم ؟ لجاري التجهيز');

        Firebase::combine('الطلبات', $message, $order->user, 'user_order_processing', $order->order_no);
    }

    public static function sendUserOrderProcessed($order): void
    {
        $message = Str::replaceArray('؟', [$order->order_no], 'تم تحويل الطلب الخاص بك رقم ؟ لجاري تم التجهيز');

        Firebase::combine('الطلبات', $message, $order->user, 'user_order_processed', $order->order_no);
    }

    public static function sendUserOrderInDelivery($order): void
    {
        $message = Str::replaceArray('؟', [$order->order_no], 'تم تحويل الطلب الخاص بك رقم ؟ لجاري التوصيل');

        Firebase::combine('الطلبات', $message, $order->user, 'user_order_in_delivery', $order->order_no);
    }

    public static function sendUserOrderReadyForDelivery($order): void
    {
        $message = Str::replaceArray('؟', [$order->order_no], 'تم تحويل الطلب الخاص بك رقم ؟ لجاهز للتوصيل');

        Firebase::combine('الطلبات', $message, $order->user, 'user_order_for_delivery', $order->order_no);
    }

    public static function sendUserOrderReadyForPickUp($order): void
    {
        $message = Str::replaceArray('؟', [$order->order_no], 'تم تحويل طلبك رقم ؟ لجاهز للإستلام');

        Firebase::combine('الطلبات', $message, $order->user, 'user_order_ready_for_pick_up', $order->order_no);
    }

    public static function sendUserOrderReceived($order): void
    {
        $message = Str::replaceArray('؟', [$order->order_no], 'تم تحويل طلبك رقم ؟ لتم الإستلام');

        Firebase::combine('الطلبات', $message, $order->user, 'user_order_received', $order->order_no);
    }

    public static function sendUserOrderDelivered($order): void
    {
        $message = Str::replaceArray('؟', [$order->order_no], 'تم تحويل طلبك رقم ؟ لتم التسليم');

        Firebase::combine('الطلبات', $message, $order->user, 'user_order_delivered', $order->order_no);
    }

    public static function sendUserOrderNotReceived($order): void
    {
        $subject = 'تم تحويل الطلب الخاص بك رقم ؟ الي لم يتم الاستلام برجاء التواصل مع إدارة التطبيق لتسلم الطلب';

        $message = Str::replaceArray('؟', [$order->order_no], $subject);

        Firebase::combine('الطلبات', $message, $order->user, 'user_order_not_received', $order->order_no);
    }

    public static function sendUserOrderReturned($order): void
    {
        $message = Str::replaceArray('؟', [$order->order_no], 'تم استرجاع الطلب الخاص بك رقم ؟ بنجاح');

        Firebase::combine('الطلبات', $message, $order->user, 'user_order_returned', $order->order_no);
    }

    public static function sendUserOrderUndertaking($order_id, $undertaking_id): void
    {
        $order = Order::find($order_id);

        $message = Str::replaceArray('؟', [$order->order_no], 'تم تحديد بنود التعهد الخاص بالطلب رقم ؟ برجاء الإطلاع عليها للموافقة او الرفض');

        Firebase::combine('الطلبات', $message, $order->user, 'user_order_undertaking', $undertaking_id);
    }

    public static function sendUserDelayPaidAction($order, $type): void
    {
        $action = $type == 'accept' ? 'قبول' : 'رفض';

        $message = Str::replaceArray('؟', [$action, $order->order_no], 'تم ؟ عملية دفع مستحقات تأخير الطلب رقم ؟ من إدارة التطبيق');

        Firebase::combine('الطلبات', $message, $order->user, 'user_order_delay_action', $order->id);
    }

    public static function sendUserThrowbackDemandAccepted($throwback): void
    {
        $subject = 'تم قبول طلب استرجاع الطلب رقم ؟ من إدارة التطبيق بنجاح';

        $message = Str::replaceArray('؟', [$throwback->order->order_no], $subject);

        Firebase::combine('طلبات الاسترجاع', $message, $throwback->user, 'user_order_return_accepted', $throwback->order->order_no);
    }

    public static function sendUserThrowbackDemandRefused($throwback): void
    {
        $subject = 'تم رفض طلب استرجاع الطلب رقم ؟ من إدارة التطبيق برجاء التواصل لمعرفة الأسباب';

        $message = Str::replaceArray('؟', [$throwback->order->order_no], $subject);

        Firebase::combine('طلبات الاسترجاع', $message, $throwback->user, 'user_order_return_refused', $throwback->order->order_no);
    }
}
