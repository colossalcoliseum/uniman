<?php

namespace App\Enums;

enum RecensionStatus: string
{
    case PENDING = 'pending';
    case CURRENTLY_REVIEWED = 'currently_reviewed';
    case PASSED_RECENSION = 'passed_recension';
    case FAILED_RECENSION = 'failed_recension';
    case REVISION_REQUIRED = 'revision_required';
    case RESUBMITTED = 'resubmitted';
    case ASSIGNED = 'assigned';
    case EXPIRED = 'expired';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'В изчакване',
            self::CURRENTLY_REVIEWED => 'Вмомента се Разглежда',
            self::PASSED_RECENSION => 'Успешно Минала Рецензия',
            self::FAILED_RECENSION => 'Неуспешно Минала Рецензия',
            self::REVISION_REQUIRED => 'Нужна Ревизия',
            self::RESUBMITTED => 'Изпратена Отново',
            self::ASSIGNED => 'Възложена',
            self::EXPIRED => 'Изтекла',

        };
    }
}
