<?php

namespace App\Enums;

enum BookStatus: string
{
    case AVAILABLE = 'AVAILABLE';
    case NOT_AVAILABLE = 'NOT_AVAILABLE';

    public function isAvailable(): bool
    {
        return match ($this) {
            self::AVAILABLE => true,
            self::NOT_AVAILABLE => false,
        };
    }
}
