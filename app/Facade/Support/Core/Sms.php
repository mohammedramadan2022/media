<?php

namespace App\Facade\Support\Core;

use App\Repository\Contracts\SmsInterface;

class Sms
{
    public function __construct(public SmsInterface $smsInterface) {}

    public static function send($number, $message): bool|array
    {
        return (new self(app(SmsInterface::class)))->_send($number, $message);
    }

    public static function code($default = 1111)
    {
        return ! config('sms.sms_provider_status') ? $default : create_rand_numbers();
    }

    private function _send($number, $message): bool|array
    {
        $numbers = is_array($number) ? implode(',', $number) : getFormattedPhone($number);

        if (! config('sms.sms_provider_status') && app()->isLocal())
        {
            info($message);

            return false;
        }

        return $this->smsInterface::send($numbers, $message);
    }
}
