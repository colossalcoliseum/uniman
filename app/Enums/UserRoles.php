<?php

namespace App\Enums;

enum UserRoles: string
{
    case ADMIN = 'admin';
    case DEAN = 'dean';
    case RECTOR = 'rector';
    case PROFESSOR = 'professor';
    case ASSISTANT = 'assistant';
    case STUDENT = 'student';
    case ASSOCIATE_PROFESSOR = 'associate_professor';

    public function labels(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::DEAN => 'Dean',
            self::RECTOR => 'Rector',
            self::PROFESSOR => 'Professor',
            self::ASSISTANT => 'Assistant',
            self::STUDENT => 'Student',
            self::ASSOCIATE_PROFESSOR => 'Associate Professor',
        };
    }

}
