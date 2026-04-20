<?php

namespace App\Enums;

enum CornerMarketLabel: string
{
    case OVER_6_5 = 'over_6_5';
    case OVER_7_5 = 'over_7_5';
    case OVER_8_5 = 'over_8_5';
    case OVER_9_5 = 'over_9_5';
    case OVER_10_5 = 'over_10_5';
    case OVER_11_5 = 'over_11_5';

    case UNDER_13_5 = 'under_13_5';
    case UNDER_12_5 = 'under_12_5';
    case UNDER_11_5 = 'under_11_5';
    case UNDER_10_5 = 'under_10_5';
    case UNDER_9_5 = 'under_9_5';
    case UNDER_8_5 = 'under_8_5';

    public function label(): string
    {
        return match ($this) {

            self::OVER_6_5 => 'Over 6.5',
            self::OVER_7_5 => 'Over 7.5',
            self::OVER_8_5 => 'Over 8.5',
            self::OVER_9_5 => 'Over 9.5',
            self::OVER_10_5 => 'Over 10.5',
            self::OVER_11_5 => 'Over 11.5',

            self::UNDER_13_5 => 'Under 13.5',
            self::UNDER_12_5 => 'Under 12.5',
            self::UNDER_11_5 => 'Under 11.5',
            self::UNDER_10_5 => 'Under 10.5',
            self::UNDER_9_5 => 'Under 9.5',
            self::UNDER_8_5 => 'Under 8.5',
        };
    }
}
