<?php

use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\TermPaperController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('consultations/calendar', [ConsultationController::class, 'calendar'])
        ->name('consultations.calendar');
    Route::get('consultations-calendar-data', [ConsultationController::class, 'calendarData'])
        ->name('consultations.calendar-data');
    Route::resource('consultations', ConsultationController::class);

});

