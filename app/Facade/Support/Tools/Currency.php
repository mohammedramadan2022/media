<?php

namespace App\Facade\Support\Tools;

use NumberFormatter;

class Currency
{
    public static function format($value, $locale = 'en_US', $style = NumberFormatter::DECIMAL, $precision = 2, $groupingUsed = true, $currencyCode = 'USD'): bool|string
    {
        $formatter = new NumberFormatter($locale, $style);

        $formatter->setAttribute(NumberFormatter::FRACTION_DIGITS, $precision);

        $formatter->setAttribute(NumberFormatter::GROUPING_USED, $groupingUsed);

        $formatter->setAttribute(NumberFormatter::MIN_FRACTION_DIGITS,0);

        $formatter->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS,100);

        if ($style == NumberFormatter::CURRENCY)
        {
            $formatter->setTextAttribute(NumberFormatter::CURRENCY_CODE, $currencyCode);
        }

        return $formatter->format($value);
    }

    public static function arabic($value): bool|string
    {
        return self::format(value: $value, locale: 'ar_AE', style: NumberFormatter::CURRENCY, currencyCode: 'SAR');
    }

    public static function english($value): bool|string
    {
        return self::format(value: $value, locale: self::currentLocale('en'), style: NumberFormatter::CURRENCY, currencyCode: self::currencyCode('en'));
    }

    public static function spellout($value): bool|string
    {
        return self::format(value: $value, locale: self::currentLocale(), style: NumberFormatter::SPELLOUT, currencyCode: self::currencyCode());
    }

    public static function locale($value): bool|string
    {
        return isLocale('ar') ? self::arabic($value) : self::english($value);
    }

    public static function default($amount): string
    {
        return number_format($amount) . ' ' . trans('back.reyal');
    }

    private static function currentLocale($locale = 'ar'): string
    {
        return isLocale($locale) ? 'ar_AE' : 'en_US';
    }

    private static function currencyCode($locale = 'ar'): string
    {
        return isLocale($locale) ? 'SAR' : 'USD';
    }
}
