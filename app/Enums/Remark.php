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
            self::A => 'Отличен',
            self::B => 'Много Добър',
            self::C => 'Добър',
            self::D => 'Среден',
            self::F => 'Слаб',
        };
    }

    public function ectsScore(): float
    {
        return match ($this) {
            self::A => 6.00,
            self::B => 5.00,
            self::C => 4.00,
            self::D => 3.00,
            self::F => 0.00,
        };
    }

    public function gpaScore(): float
    {
        return match ($this) {
            self::A => 4.00,
            self::B => 3.00,
            self::C => 2.00,
            self::D => 1.00,
            self::F => 0.00,
        };
    }

    public function bgScore(): int
    {
        return match ($this) {
            self::A => 6,
            self::B => 5,
            self::C => 4,
            self::D => 3,
            self::F => 2,
        };
    }

    public function passingScore(): int
    {
        return match ($this) {
            self::A => 90,
            self::B => 75,
            self::C => 60,
            self::D => 50,
            self::F => 0,
        };
    }

    public function slug(): string
    {
        return $this->value;

    }

    public function letterGrading(): string
    {
        return $this->name;
    }
}
