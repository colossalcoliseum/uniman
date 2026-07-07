<?php

namespace App\Enums;

enum TermPaperStatus: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
    case REVISION_REQUIRED = 'revision_required';
    case IN_REVIEW = 'in_review';
    case DEFENDED = 'defended';
    case FAILED = 'failed';
    case AVAILABLE = 'available';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'В изчакване',
            self::ACCEPTED => 'Приета',
            self::REJECTED => 'Отхвърлена',
            self::REVISION_REQUIRED => 'Нужна Ревизия',
            self::IN_REVIEW => 'Процес на Разглеждане',
            self::DEFENDED => 'Защитена',
            self::FAILED => 'Неуспешно Взета',
            self::AVAILABLE => 'Налична',
        };
    }
}
