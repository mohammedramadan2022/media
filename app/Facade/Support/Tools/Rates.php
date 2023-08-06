<?php

namespace App\Facade\Support\Tools;

class Rates
{
    public static function setCalculatedRate($model, $rate): array
    {
        $current_count = $model->rates_count;

        $mul = ($current_count * $model->rate);

        $sum = ($mul + $rate);

        $new_count = ($current_count + 1);

        $data = ['rate' => ($sum / $new_count), 'rates_count' => $new_count];

        $model->update($data);

        return $data;
    }

    public static function getRate($collections): object
    {
        return (object)['avg' => self::getRates($collections), 'total' => $collections ? $collections->count() : 0];
    }

    public static function getRates($collections): float|int
    {
        $rates = $collections ? $collections->map(fn($item) => (int)$item->rate)->toArray() : [];

        if (empty($rates)) return 0;

        $count = count($rates);

        return ($count != 0) ? round(array_sum($rates) / $count,1) : 0;
    }

    public static function getRateAvg($rates): float|int
    {
        return self::getRates($rates);
    }

    public static function getStarsRateCount($collection): array
    {
        return [
            'one'   => self::getRatePercentage($collection, 1),
            'two'   => self::getRatePercentage($collection, 2),
            'three' => self::getRatePercentage($collection, 3),
            'four'  => self::getRatePercentage($collection, 4),
            'five'  => self::getRatePercentage($collection, 5),
        ];
    }

    private static function getRatePercentage($collection, $rate): array
    {
        $rateCount = $collection->where('rate', $rate)->count();

        $percent = ($collection->count() != 0) ? (($rateCount / $collection->count()) * 100) : 0;

        return ['count' => $rateCount, 'percentage' => round($percent)];
    }
}
