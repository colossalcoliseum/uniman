<?php

use App\Http\Controllers\TermPaperController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('term-papers', TermPaperController::class);

    Route::post('term-papers/{termPaper}/restore', [TermPaperController::class, 'restore'])
        ->name('term-papers.restore')
        ->withTrashed();

    Route::post('term-papers/{termPaper}/claim', [TermPaperController::class, 'claim'])
        ->name('term-papers.claim')
        ->middleware('auth');
 
});

