<?php

namespace App\Enums;

enum ConsultationStatus: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'В изчакване',
            self::ACCEPTED => 'Приета',
            self::REJECTED => 'Отхвърлена',
        };
    }
}
