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
            self::PENDING => 'Pending',
            self::CURRENTLY_REVIEWED => 'Currently Reviewed',
            self::PASSED_RECENSION => 'Passed Recension',
            self::FAILED_RECENSION => 'Failed Recension',
            self::REVISION_REQUIRED => 'Revision Required',
            self::RESUBMITTED => 'Resubmitted',
            self::ASSIGNED => 'Assigned',
            self::EXPIRED => 'Expired',

        };
    }
}
