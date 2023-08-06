<?php

namespace App\Repository\Contracts;

interface PayInterface
{
    public static function charge($arr);
}
