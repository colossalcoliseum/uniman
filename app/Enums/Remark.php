<?php

namespace App\Enums;

enum Remark: string
{
    case A = 'excellent';
    case B = 'good';
    case C = 'average';
    case D = 'below average';
    case F = 'fail';

    public function label(): string
    {
        return match ($this) {
            self::A => 'Excellent',
            self::B => 'Good',
            self::C => 'Average',
            self::D => 'Below Average',
            self::F => 'Fail',
        };
    }
}
