<?php

namespace App\Facade\Support\Tools;

class BuitIn
{
    public static function strlen($string): int
    {
        $index = 0;

        while(!empty($string[$index])) $index++;

        return $index;
    }

    public static function array_sum($array)
    {
        $sum = 0;

        foreach($array as $num) $sum += $num;

        return $sum;
    }

    public static function str_replace($search, $replace, $subject): string
    {
        $res = '';

        for($i=0;$i<=self::strlen($subject);$i++)
        {
            if(empty($subject[$i])) continue;

            if(self::is_array($search) && self::in_array($subject[$i], $search))
            {
                foreach($search as $_rep)
                {
                    $res .= ($subject[$i] == $_rep) ? $replace : '';
                }
            }
            else
            {
                $res .= $subject[$i] == $search ? $replace : $subject[$i];
            }
        }

        return $res;
    }

    public static function in_array(mixed $needle, array $haystack): bool
    {
        foreach($haystack as $element)
        {
            if($element !== $needle) continue;

            return true;
        }

        return false;
    }

    public static function is_array($item): bool
    {
        return (array)$item === $item;
    }

    public static function is_string($value): bool
    {
        if(self::is_array($value)) return false;

        return (string)$value === $value;
    }

    public static function is_bool(mixed $value): bool
    {
        if(self::is_array($value)) return false;

        return self::in_array($value, [true, false]);
    }

    public static function array_filter(array $array, callable $callback = null): array
    {
        $filtered = [];

        foreach($array as $value)
        {
            if((!$callback || !$callback($value)) && (empty($value) && !$value)) continue;

            $filtered[] = $value;
        }

        return $filtered;
    }
}
