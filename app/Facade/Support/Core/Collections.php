<?php

namespace App\Facade\Support\Core;

use App\Facade\Support\Tools\Time;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class Collections
{
    // Collections with months and days;
    public static function berMonthCount($collection): array
    {
        $months = [];

        foreach (getMonthsArray() as $key => $month) {
            $months[$key] = $collection->filter(self::byMonthName(ucfirst($month)));
        }

        return $months;
    }

    public static function perDayCount($collection): array
    {
        $days = [];

        foreach (getDaysArray() as $day) {
            $days[$day] = $collection->filter(self::getCollectionByDayName(ucfirst($day)));
        }

        return $days;
    }

    public static function getMonthsTotalBarForYear($collection, $column = 'total'): array
    {
        $months = self::berMonthCount($collection);

        return self::getMonthsTotal($months, $column);
    }

    public static function getMonthsTotalOnlyBarForYear($collection, $column = 'total'): array
    {
        $months = self::berMonthCount($collection);

        return self::getMonthsTotalOnly($months, $column);
    }

    public static function getWeeksTotalBar($collection, $column = 'total'): array
    {
        $days = self::perDayCount($collection);

        return self::getWeeksTotal($days, $column);
    }

    public static function getWeeksDaysTotalOnlyBar($collection, $column = 'total'): array
    {
        $days = self::perDayCount($collection);

        return self::getWeekDaysTotalOnly($days, $column);
    }

    public static function getYearTotalFromColumnInCollection($collection, $col): array
    {
        $months = [];

        foreach (self::berMonthCount($collection) as $month => $item) {
            $months[] = (int) round($item->sum($col));
        }

        return $months;
    }

    public static function getYearTotalFromColumnInModel($model, $col): array
    {
        $months = [];

        foreach (self::berMonthCount($model::whereYear('created_at', date('Y'))->get()) as $item) {
            $months[] = (int) round($item->sum($col));
        }

        return $months;
    }

    public static function getTotalFromColumn($collection, $col): array
    {
        $days = [];

        foreach (self::perDayCount($collection) as $day => $element) {
            $days[] = (int) round($element->sum($col));
        }

        return $days;
    }

    public static function getWeekTotalFromColumnInModel($model, $col): array
    {
        $days = [];

        foreach (self::perDayCount($model::whereBetweenForWeek()->get()) as $element) {
            $days[] = (int) round($element->sum($col));
        }

        return $days;
    }

    public static function berMonthAndDaysCount($collection): array
    {
        $months = [];

        foreach (getMonthsArray() as $index => $month) {
            $months[$index] = self::perDayCount($collection->filter(self::byMonthName(ucfirst($month))));
        }

        return $months;
    }

    public static function getMonthsTotal($months, $column): array
    {
        $totals = [];

        foreach ($months as $i => $month) {
            $totals[$i] = ['total' => $month->sum($column), 'count' => $month->count()];
        }

        return $totals;
    }

    public static function getMonthsTotalOnly($months, $column): array
    {
        return self::getWeekDaysTotalOnly($months, $column);
    }

    public static function getWeeksTotal($days, $column): array
    {
        $totals = [];

        foreach ($days as $i => $day) {
            $totals[$i] = ['total' => empty($day) ? 0 : $day->sum($column), 'count' => empty($day) ? 0 : $day->count()];
        }

        return $totals;
    }

    public static function getWeekDaysTotalOnly($days, $column): array
    {
        $totals = [];

        $key = 0;

        foreach ($days as $day) {
            $totals[$key] = $day->sum($column);
            $key++;
        }

        return $totals;
    }

    public static function getYearMonths($without_inst = false): array
    {
        $months = [];

        foreach (range(1, 12) as $index => $month) {
            $months[$index] = Carbon::create(date('Y'), $month);
        }

        return $without_inst ? range(1, 12) : $months;
    }

    public static function getYearMonthsWithOrWithoutInst($with = false): array
    {
        $current_month = (int) now()->format('m');

        return arr()->where(self::getYearMonths(! $with), function ($value) use ($with, $current_month) {
            return ! $with ? $value >= $current_month : (int) $value->format('m') >= $current_month;
        });
    }

    // Times;

    public static function getTimeSum($collection, $col): string
    {
        $callback = function ($item) use ($col) {
            return Time::getSecondsFromTime($item->$col);
        };

        $res = array_sum($collection->map($callback)->toArray());

        $sum = Time::getTimeFromSeconds($res);

        if ($res > 3600) {
            return $sum.' '.trans('back.time.hour');
        }

        if ($res < 3600 && $res != 0) {
            return explode('00:', $sum)[1].' '.trans('back.time.minute');
        }

        return trans('back.no-value');
    }

    public static function getUserCountryFromIp(): object|bool|array
    {
        $response = Http::get('https://ip-api.com/json/'.request()->ip())->object();
        //        $response = Http::get('http://ip-api.com/json/197.61.40.125')->object();

        if ($response->status == 'fail') {
            return false;
        }

        return $response;
    }

    public static function localizeDate($date)
    {
        //                 $smallDays   = ["Sat", "Sun", "Mon", "Tue", "Wed" , "Thu", "Fri"];
        if (getLocale() == 'ar') {
            $arDays = getWeekDays();
            //          $date        = str_replace($smallDays, $arDays, $date);

            $days = map(getDaysArray(), fn ($day) => ucfirst($day));

            $date = str_replace($days, $arDays, $date);

            $smallMonths = map(array_keys(getMonthsArray()), fn ($month) => ucfirst($month));

            $arMonths = getYearMonths();
            //          $date        = str_replace($smallMonths, $arMonths, $date);

            $months = map(array_values(getMonthsArray()), fn ($month) => ucfirst($month));

            $date = str_replace($months, $arMonths, $date);

            header('Content-Type: text/html; charset=utf-8');

            //                $standard_nums       = map(range(9,9), fn($i) => (string)$i);
            //                $eastern_arabic_nums = ["٠","١","٢","٣","٤","٥","٦","٧","٨","٩"];
            //                $date                = str_replace($standard_nums , $eastern_arabic_nums , $date);

            $enAmPm = ['AM', 'PM'];
            $arAmPm = ['صباحاً', 'مساءً'];
            $date = str_replace($enAmPm, $arAmPm, $date);
        }

        return $date;
    }

    // Collections

    public static function getInSelectForm($collection, $name = 'name'): array
    {
        $arr = [];

        foreach ($collection as $item) {
            $arr[$item->id] = $item->$name;
        }

        return $arr;
    }

    public static function getTableYearsList($model, $column = 'created_at'): array
    {
        $years = [];

        $collection = $model::select($column)->get()->pluck($column)->toArray();

        foreach ($collection as $date) {
            $years[] = $date->format('Y');
        }

        return array_unique($years);
    }

    private static function getCollectionByDayName($day): callable
    {
        return function ($item) use ($day) {
            return $item->created_at->format('l') == $day;
        };
    }

    private static function byMonthName($month): callable
    {
        return function ($item) use ($month) {
            return $item->created_at->format('F') == $month;
        };
    }
}
