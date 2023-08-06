<?php

namespace App\Facade\Support\Google;

class Geo
{
    public static function distance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000): float|int
    {
        $from = (object)['lat' => deg2rad($latitudeFrom), 'lon' => deg2rad($longitudeFrom)];

        $to = (object)['lat' => deg2rad($latitudeTo), 'lon' => deg2rad($longitudeTo)];

        $latDelta = $to->lat - $from->lat;

        $lonDelta = $to->lon - $from->lon;

        $powLat = pow(sin($latDelta / 2), 2);

        $powLng = pow(sin($lonDelta / 2), 2);

        $angle = 2 * asin(sqrt($powLat + cos($from->lat) * cos($to->lat) * $powLng));

        return ($angle * $earthRadius) / 1000;
    }
}