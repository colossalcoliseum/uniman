<?php

namespace App\Enums;

enum GenAiCheckStatus:string
{
    case NOT_CHECKED = 'not_checked';
    case LOW_RISK = 'low_risk';
    case MEDIUM_RISK = 'medium_risk';
    case HIGH_RISK = 'high_risk';

    public function label(): string
    {
        return match ($this) {
            self::NOT_CHECKED => 'Непроверено',
            self::LOW_RISK => 'Нисък риск',
            self::MEDIUM_RISK => 'Среден риск',
            self::HIGH_RISK => 'Висок риск',
        };
    }
}
