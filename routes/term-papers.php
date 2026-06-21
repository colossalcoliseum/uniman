<?php

use App\Http\Controllers\TermPaperController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('term-papers', TermPaperController::class);

    Route::post('term-papers/{termPaper}/restore', [TermPaperController::class, 'restore'])
        ->name('term-papers.restore')
        ->withTrashed();
});

