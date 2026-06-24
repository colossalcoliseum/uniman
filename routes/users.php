<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('users/teachers', [UserController::class, 'teachers'])->name('users.teachers');
    Route::get('users/students', [UserController::class, 'students'])->name('users.students');

    Route::resource('users', UserController::class)->except(['index']);

    Route::post('users/{id}/restore', [UserController::class, 'restore'])
        ->name('users.restore')
        ->withTrashed();

    Route::patch('users/{user}/toggle-active', [UserController::class, 'toggleActive'])
        ->name('users.toggle-active');

    Route::patch('users/{user}/change-role', [UserController::class, 'changeRole'])
        ->name('users.change-role');
});

