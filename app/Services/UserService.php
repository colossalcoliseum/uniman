<?php

namespace App\Services;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Enums\UserRole;
use App\Enums\UserType;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserService
{
    public function getAllTeachers()
    {
        $teachers = [UserRole::ASSOCIATE_PROFESSOR->value, UserRole::PROFESSOR->value, UserRole::ASSISTANT->value];

        return Cache::remember('teachers', now()->addHours(1), function () use ($teachers) {
            return User::whereIn('role', $teachers)->where('type', UserType::TEACHER->value)->get();
        });
    }

    public function getAllStudents()
    {

        return Cache::remember('students', now()->addHours(1), function () {
            return User::where('role', UserRole::STUDENT->value)
                ->where('type', UserType::STUDENT)
                ->get();
        });

    }

    public function createUser( )
    {

    }

    public function updateUser( )
    {



    }

    public function deleteUser( )
    {

    }
}
