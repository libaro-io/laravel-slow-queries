<?php


namespace Libaro\LaravelSlowQueries\ValueObjects;



class TimeRanges
{
    public const THIRTY_MINUTES = 30;
    public const THREE_HOURS = 60*3;
    public const TWELVE_HOURS = 60*12;
    public const ONE_DAY = 60*24;
    public const ONE_WEEK = 60*24*7;
    public const FOUR_WEEKS = 60*24*7*4;
    public const THREE_MONTHS = 60*24*31*3;

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
                'label' => 'Thirty minutes',
                'duration' => self::THIRTY_MINUTES
            ],
            self::THREE_HOURS => [
                'label' => 'Three hours',
                'duration' => self::THREE_HOURS
            ],
            self::TWELVE_HOURS => [
                'label' => 'Twelve hours',
                'duration' => self::TWELVE_HOURS
            ],
            self::ONE_DAY => [
                'label' => 'One day',
                'duration' => self::ONE_DAY
            ],
            self::ONE_WEEK => [
                'label' => 'One week',
                'duration' => self::ONE_WEEK
            ],
            self::FOUR_WEEKS => [
                'label' => 'Four weeks',
                'duration' => self::FOUR_WEEKS
            ],
            self::THREE_MONTHS => [
                'label' => 'Three months',
                'duration' => self::THREE_MONTHS
            ]
        ];


    }
}
