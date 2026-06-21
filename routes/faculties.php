<?php

use App\Http\Controllers\FacultyController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('faculties', FacultyController::class);

    Route::post('faculties/{id}/restore', [FacultyController::class, 'restore'])
        ->name('institutions.restore')
        ->withTrashed();


});

