<?php

namespace App\Enums;

enum CardLevelLabel: string
{
    case SAFE = 'safe';
    case MEDIUM = 'medium';
    case AGGRESSIVE = 'aggressive';

    public function label(): string
    {
        return match ($this) {
            self::SAFE => 'Conservador',
            self::MEDIUM => 'Moderado',
            self::AGGRESSIVE => 'Agressivo',
        };
    }
}
