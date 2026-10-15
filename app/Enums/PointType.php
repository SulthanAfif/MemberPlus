<?php

namespace App\Enums;

enum PointType: string
{
    case Earn = 'earn';
    case Redeem = 'redeem';
    case Adjust = 'adjust';
    case Expire = 'expire';

    public function label(): string
    {
        return match ($this) {
            self::Earn => 'Perolehan',
            self::Redeem => 'Penukaran',
            self::Adjust => 'Penyesuaian',
            self::Expire => 'Kedaluwarsa',
        };
    }
}
