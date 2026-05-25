<?php

namespace App\Enums;

enum TermPaperStatus: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
    case REVISION_REQUIRED = 'revision required';
    case IN_REVIEW = 'in Review';
    case DEFENDED = 'defended';
    case FAILED = 'failed';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::ACCEPTED => 'Accepted',
            self::REJECTED => 'Rejected',
            self::REVISION_REQUIRED => 'Revision Required',
            self::IN_REVIEW => 'In Review',
            self::DEFENDED => 'Defended',
            self::FAILED => 'Failed',
        };
    }
}
