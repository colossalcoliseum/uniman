<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::inertia('/', 'welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');
Route::get('dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__ . '/settings.php';
require __DIR__ . '/users.php';
require __DIR__ . '/term-papers.php';
require __DIR__ . '/recensions.php';
require __DIR__ . '/consultations.php';
require __DIR__ . '/institutions.php';
require __DIR__ . '/faculties.php';
require __DIR__ . '/specialties.php';
