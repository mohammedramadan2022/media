<?php

namespace App\Enums;

enum WalletEnum: string
{
    public const SHIPPED = 'shipped';

    public const REFUND = 'refund';

    public const DISCOUNTED = 'discounted';

    public const UNKNOWN = 'UNKNOWN';
}
