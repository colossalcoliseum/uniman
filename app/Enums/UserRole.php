<?php

namespace App\Enums;

enum UserRole: string
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
            self::ADMIN => 'Админ',
            self::DEAN => 'Декан',
            self::RECTOR => 'Ректор',
            self::PROFESSOR => 'Професор',
            self::ASSISTANT => 'Асистент',
            self::STUDENT => 'Студент',
            self::ASSOCIATE_PROFESSOR => 'Доцент',
        };
    }

}
