<?php


namespace Libaro\LaravelSlowQueries\ValueObjects;



class TimeRanges
{
    public const THIRTY_MINUTES = 1;
    public const THREE_HOURS = 3;
    public const TWELVE_HOURS = 5;
    public const ONE_DAY = 6;
    public const ONE_WEEK = 8;
    public const FOUR_WEEKS = 11;

    /**
     * @param $type
     * @return bool
     */
    public static function isValid(string $type): bool
    {
        return in_array($type, self::getValids(), true);
    }

    /**
     * @return array<int, array<string, int|string>>
     */
    public static function getValids(): array
    {
        return [
            self::THIRTY_MINUTES => [
                'label' => 'thirty minutes',
                'duration' => 30
            ],
            self::THREE_HOURS => [
                'label' => 'three hours',
                'duration' => 60 * 3
            ],
            self::TWELVE_HOURS => [
                'label' => 'twelve hours',
                'duration' => 60 * 12
            ],
            self::ONE_DAY => [
                'label' => 'one day',
                'duration' => 60 * 24
            ],
            self::ONE_WEEK => [
                'label' => 'one week',
                'duration' => 60 * 24 * 7
            ],
            self::FOUR_WEEKS => [
                'label' => 'four weeks',
                'duration' => 60 * 24 * 7 * 4
            ]
        ];


    }
}
