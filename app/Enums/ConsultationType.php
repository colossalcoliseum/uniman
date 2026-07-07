<?php

namespace App\Enums;

enum ConsultationType: string
{
    case ONLINE = 'online';
    case IN_PERSON = 'in_person';

    public function label(): string
    {
        return match ($this) {
            self::ONLINE => 'Онлайн',
            self::IN_PERSON => 'На Живо',
        };
    }
}

