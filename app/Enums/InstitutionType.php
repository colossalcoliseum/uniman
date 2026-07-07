<?php

namespace App\Enums;

enum InstitutionType: string
{
    case UNIVERSITY = 'university';
    case SPECIALIZED_HIGHER_SCHOOL = 'specialized_higher_school';
    case INDEPENDENT_COLLEGE = 'independent_college';

    public function label(): string
    {
        return match ($this) {
            self::UNIVERSITY => 'Университет',
            self::SPECIALIZED_HIGHER_SCHOOL => 'Специализирано Висше Училище',
            self::INDEPENDENT_COLLEGE => 'Независим Колеж',
        };
    }
}
