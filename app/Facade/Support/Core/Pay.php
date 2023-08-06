<?php

namespace App\Facade\Support\Core;

use App\Repository\Contracts\PayInterface;

class Pay
{
    public function __construct(public PayInterface $payInterface) {}

    public static function charge($arr): object
    {
        return (object) (new self(app(PayInterface::class)))->_charge($arr);
    }

    private function _charge($arr)
    {
        return $this->payInterface->charge($arr);
    }

    public static function setCallbackUrl($name): string
    {
        $web = (request()->header('website') == 'true') ? '-web' : '';

        return root().'/api/payments/'.$name.$web.'-success?lang='.request()->header('lang') ?? 'ar';
    }
}
