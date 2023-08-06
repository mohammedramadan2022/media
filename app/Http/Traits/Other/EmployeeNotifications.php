<?php

namespace App\Http\Traits\Other;

use App\Facade\Support\Core\Firebase;
use App\Models\Admin;
use Illuminate\Support\Str;

trait EmployeeNotifications
{
    public static function sendEmployeeAcceptVacationDemand($vacation): void
    {
        $subject = 'تم قبول طلب الإجازة المقدم بالمدة من ؟ لالمدة الي ؟ من قبل إدارة التطبيق';

        $message = Str::replaceArray('؟', [$vacation->from->format('Y-m-d'), $vacation->to->format('Y-m-d')], $subject);

        Firebase::push('طلبات الإجازة', $message, $vacation->admin, 'employee_vacation_demand_accepted', $vacation->id);
    }

    public static function sendEmployeeAcceptedUndertaking($undertaking): void
    {
        $subject = 'قام العميل صاحب الطلب رقم ؟ بقبول طلب التعهد - المرفق مع الطلب - بنجاح';

        $message = Str::replaceArray('؟', [$undertaking->order_id], $subject);

        Firebase::push('التعهدات', $message, $undertaking->admin, 'employee_order_undertaking_accepted', $undertaking->id);
    }

    public static function sendEmployeeRefuseUndertaking($undertaking): void
    {
        $subject = 'قام العميل صاحب الطلب رقم ؟ برفض طلب التعهد - المرفق مع الطلب';

        $message = Str::replaceArray('؟', [$undertaking->order_id], $subject);

        Firebase::push('التعهدات', $message, $undertaking->admin, 'employee_order_undertaking_refused', $undertaking->id);
    }

    public static function sendEmployeeRefuseVacationDemand($vacation): void
    {
        $subject = 'تم رفض طلب الإجازة المقدم بالمدة من ؟ لالمدة الي ؟ من قبل إدارة التطبيق برجاء التواصل لمعرفة الأسباب';

        $message = Str::replaceArray('؟', [$vacation->from->format('Y-m-d'), $vacation->to->format('Y-m-d')], $subject);

        Firebase::push('طلبات الإجازة', $message, $vacation->admin, 'employee_vacation_demand_refused', $vacation->id);
    }

    public static function sendEmployeeAcceptAdvanceDemand($advance): void
    {
        $subject = 'تم قبول طلب السلفة المقدم بمبلغ ؟ وبتاريخ ؟ من قبل إدارة التطبيق';

        $message = Str::replaceArray('؟', [$advance->amount, $advance->date->format('Y-m-d')], $subject);

        Firebase::push('طلبات السلفة', $message, $advance->admin, 'employee_advance_demand_accepted', $advance->id);
    }

    public static function sendEmployeeRefuseAdvanceDemand($advance): void
    {
        $subject = 'تم رفض طلب السلفة المقدم بمبلغ ؟ وبتاريخ ؟ من قبل إدارة التطبيق برجاء التواصل لمعرفة الأسباب';

        $message = Str::replaceArray('؟', [$advance->amount, $advance->date->format('Y-m-d')], $subject);

        Firebase::push('طلبات السلفة', $message, $advance->admin, 'employee_advance_demand_refused', $advance->id);
    }

    public static function sendDeliveryProviderNewOrder($order, $provider_id): void
    {
        $admin = Admin::find($provider_id);

        $subject = 'تم تعينك كمندوب توصيل للطلب رقم ؟';

        $message = Str::replaceArray('؟', [$order->order_no], $subject);

        Firebase::push('طلب جديد !', $message, $admin, 'employee_new_delivery_order', $order->id);
    }

    public static function sendEmployeeUndertakingAction($undertaking, $is_accepted): void
    {
        ($is_accepted) ? self::sendEmployeeAcceptedUndertaking($undertaking) : self::sendEmployeeRefuseUndertaking($undertaking);
    }
}
