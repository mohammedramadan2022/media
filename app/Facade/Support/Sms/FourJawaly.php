<?php

namespace App\Facade\Support\Sms;

use App\Repository\Contracts\SmsInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FourJawaly implements SmsInterface
{
    public static function messages($code): string
    {
        return match ($code) {
            100     => 'تم إرسال الرسالة بنجاح',
            106     => 'اسم المرسل غير متاح',
            102     => 'اسم المستخدم غير صحيح',
            103     => 'كلمة المرور غير صحيحة',
            108     => 'لا يوجد أرقام صالحة للإرسال',
            1015    => 'اسم المرسل فارغ',
            1014    => 'لم يتم وضع رقم مستقبل',
            1012    => 'لم يتم وضع كلمة المرور',
            1011    => 'لم يتم وضع اسم المستخدم',
            default => 'Unknown Error !.',
        };
    }

    public static function errors(): array
    {
        return [1011, 1012, 1014, 1015, 1013, 106, 102, 103, 108];
    }

    public static function data($number, $message): array
    {
        return [
            'username' => config('sms.sms_number'),
            'password' => config('sms.sms_password'),
            'numbers'  => $number,
            'unicode'  => 'E',
            'message'  => $message,
            'sender'   => config('sms.sms_sender_name'),
            'return'   => 'json',
        ];
    }

    public static function send($number, $message): array
    {
        $result = Http::post('https://www.4jawaly.net/api/sendsms.php', self::data($number, $message))->object();

        $code = $result->Code;

        if (in_array($code, self::errors())) Log::warning('4jawaly Sms : ' . $result->MessageIs);

        return ['code' => $code, 'message' => self::messages($code)];
    }
}
