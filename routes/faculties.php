<?php

use App\Http\Controllers\FacultyController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('faculties', FacultyController::class);

    Route::post('faculties/{faculty}/restore', [FacultyController::class, 'restore'])
        ->name('faculties.restore')
        ->withTrashed();


});

