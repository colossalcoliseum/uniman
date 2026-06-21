<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('users', UserController::class);

    Route::post('users/{id}/restore', [UserController::class, 'restore'])
        ->name('users.restore')
        ->withTrashed();

    Route::patch('users/{user}/toggle-active', [UserController::class, 'toggleActive'])
        ->name('users.toggle-active');

    Route::patch('users/{user}/change-role', [UserController::class, 'changeRole'])
        ->name('users.change-role');
});

