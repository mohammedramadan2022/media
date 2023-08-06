<?php

namespace App\Repository\Contracts;

interface SmsInterface
{
    public static function messages($code): string;

    public static function data($number, $message): array;

    public static function send($number, $message): array;
}
