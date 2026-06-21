<?php

use App\Http\Controllers\RecensionController;
 use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('recensions', RecensionController::class);

    Route::post('recensions/{recension}/restore', [RecensionController::class, 'restore'])
        ->name('recensions.restore')
        ->withTrashed();
});

