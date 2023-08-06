<?php

namespace App\Enums;

enum RoleEnum : int
{
    public const SUPPER_ADMIN = 1;

    public const CEO = 2;

    public const ORDERS_OFFICER = 3;

    public const DELIVERY_OFFICER = 4;

    public const DELIVERY_PROVIDER = 5;

    public const WAREHOUSE_OFFICER = 6;
}
