<?php

namespace Libaro\LaravelSlowQueries;

class FormatHelper
{
    /**
     * @return string
     */
    public static function abbreviate(string $string, int $length = 30, bool $abbreviateFromStart = false)
    {
        if (strlen($string) > ($length - 3)) {
            if ($abbreviateFromStart) {
                $length *= -1;
                $string = substr($string, $length);
            } else {
                $string = substr($string, 0, $length);
            }

            if ($abbreviateFromStart) {
                $string = '...'.$string;
            } else {
                $string = $string.'...';
            }
        }

        return $string;
    }

    public static function formatNumber(float $number, int $afterComma = 0): string
    {
        $value = round($number, $afterComma);
        $value = (float) $value;

        return number_format($value, $afterComma, ',', '.');
    }
}
