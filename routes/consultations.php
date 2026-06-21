<?php

use App\Http\Controllers\TermPaperController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('consultations', TermPaperController::class);

    Route::post('consultations/{consultation}/restore', [TermPaperController::class, 'restore'])
        ->name('consultations.restore')
        ->withTrashed();
});

