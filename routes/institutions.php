<?php

use App\Http\Controllers\InstitutionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('institutions', InstitutionController::class);

    Route::post('institutions/{id}/restore', [InstitutionController::class, 'restore'])
        ->name('institutions.restore')
        ->withTrashed();


});

