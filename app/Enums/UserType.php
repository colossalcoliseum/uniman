<?php

namespace App\Enums;

enum UserType: string
{
    case STUDENT = 'student';
    case TEACHER = 'teacher';

    public function labels(): string
    {
        return match ($this) {
            self::STUDENT => 'Студент',
            self::TEACHER => 'Преподавател',

        };
    }
}
