<?php

namespace App\Facade\mixins;

use App\Facade\Support\Tools\Time;
use Closure;

class CarbonMixin
{
    public function getCurrentWeekDays(): Closure
    {
        return fn () => Time::getCurrentWeekDays();
    }

    public function getTimesList(): Closure
    {
        return fn ($from, $to, $duration = 60) => Time::getTimesList($from, $to, $duration);
    }
}
