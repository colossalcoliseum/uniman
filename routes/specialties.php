<?php

use App\Http\Controllers\SpecialtyController;
 use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('specialties', SpecialtyController::class);

    Route::post('specialties/{specialty}/restore', [SpecialtyController::class, 'restore'])
        ->name('specialties.restore')
        ->withTrashed();
});

