<?php

namespace App\Facade\Support\Tools;

class Percentage
{
    public static function main($percent, $value, $isDiscount, $onlyDiscount): float|int
    {
        // Y = X * P%;
        $percentage = $percent / 100;

        $discount = ($value * $percentage);

        if ($onlyDiscount) return $discount;

        if ($isDiscount) return (int) $value - $discount; // in case of we have a discount coupon value for example;

        return (int) $value + $discount; // in case of we have a tax value;
    }

    public static function total($percent, $value): float|int
    {
        return self::main($percent, $value,true,false);
    }

    public static function discount($percent, $value): float|int
    {
        return self::main($percent, $value,false,true);
    }
}
