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
            self::UNIVERSITY => 'University',
            self::SPECIALIZED_HIGHER_SCHOOL => 'Specialized Higher School',
            self::INDEPENDENT_COLLEGE => 'Independent College',
        };
    }
}
