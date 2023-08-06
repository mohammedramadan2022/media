<?php

namespace App\Enums;

enum PaymentEnum: string
{
    public const DELAYED = 'delayed'; // مؤجل الدفع

    public const NOT_PAID = 'not_paid'; // لم يتم الدفع

    public const PAID = 'paid'; // تم الدفع

    public const WAIT_TO_PAY = 'wait_to_pay'; // في انتظار الدفع

    public const OWES_A_DELAY = 'owes_a_delay'; // مدين بالتأخير

    // Payment methods
    public const CASH = 'cash';

    public const VISA = 'visa';

    public const WALLET = 'wallet';

    public const CURRENCY = 'SAR';

    public const NEW_DELAY_CASH = 2;

    public const REFUSED_DELAY_CASH = 0;

    public const ACCEPTED_DELAY_CASH = 1;

    public const PENDING_DELAY_CASH = null;
}
