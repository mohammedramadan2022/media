<?php

namespace App\Facade\Support\Tools;

use Carbon\Carbon;

class Time
{
    public static function getTimeFromSeconds($seconds): string
    {
        $hours = floor($seconds / 3600);

        $mins = floor($seconds / 60 % 60);

        $secs = floor($seconds % 60);

        return carbon()->createFromTime($hours, $mins, $secs)->format('H:i:s');
    }

    public static function getSecondsFromTime($time): int
    {
        return Carbon::parse($time)->secondsSinceMidnight();
    }

    public static function createDateTime($time): string
    {
        return self::createFrom2Format('H:i','h:i A', $time);
    }

    public static function createFrom2Format($format1, $format2, $time): string
    {
        return Carbon::createFromFormat($format1, $time)->format($format2);
    }

    public static function getTimesList($from, $to, $duration = 60): array
    {
        $_from = Carbon::createFromFormat('H:i', $from);

        $_to = Carbon::createFromFormat('H:i', $to);

        $diff = $_from->diffInHours($_to);

        $times = [];

        for ($i = 0; $i <= $diff; $i++) {
            $times[$i] = ($i == 0) ? $_from->format('H:i') : $_from->addMinutes($duration)->format('H:i');
        }

        return $times;
    }

    public static function getCurrentWeekDays(): array
    {
        $result = [];

        $current = strtotime(Carbon::tomorrow());

        while ($current <= strtotime(now()->addWeek())) {
            $result[] = date('Y-m-d', $current);

            $current = strtotime('+1 day', $current);
        }

        return $result;
    }

    public static function createFullDatetime($date, $time, $format = 'Y-m-d H:i'): bool|Carbon
    {
        return Carbon::createFromFormat($format,$date . ' ' . $time);
    }

    public static function create24Format($value): bool|Carbon
    {
        return Carbon::createFromFormat('H:i', $value);
    }
}
