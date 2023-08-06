<?php

namespace App\Facade\Support\Sms;

use App\Repository\Contracts\SmsInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Hisms implements SmsInterface
{
    public static function messages($code): string
    {
        return match ($code) {
            1       => 'إسم المستخدم غير صحيح',
            2       => 'كلمة المرور غير صحيحة',
            404     => 'لم يتم إدخال جميع البرامترات المطلوبة',
            403     => 'تم تجاوز عدد المحاولات المطلوبة',
            504     => 'الحساب معطل',
            4       => 'لا يوجد أرقام',
            5       => 'لا يوجد رسالة',
            6       => 'سيندر خطئ',
            7       => 'سيندر غير مفعل',
            8       => 'الرسالة تحتوي كلمة ممنوعة',
            9       => 'لا يوجد رصيد',
            10      => 'صيغة التاريخ خاطئة',
            11      => 'صيغة الوقت خاطئة',
            default => 'تم الإرسال',
        };
    }

    public static function errors(): array
    {
        return [1, 2, 404, 403, 504, 4, 5, 6, 7, 8, 9, 10, 11];
    }

    public static function data($number, $message): array
    {
        return [
            'send_sms' => '',
            'username' => config('sms.sms_number'),
            'password' => config('sms.sms_password'),
            'numbers'  => $number,
            'sender'   => config('sms.sms_sender_name'),
            'message'  => $message,
        ];
    }

    public static function send($number, $message): array
    {
        $code = Http::post('https://hisms.ws/api.php', self::data($number, $message))->body();

        $result = ['message' => self::messages($code), 'code' => $code];

        if (in_array((int)$code, self::errors())) Log::warning('Hisms : ' . $result['message']);

        return $result;
    }
}
