<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;

Route::redirect('/', '/dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::resource('cars',CarController::class)->except('show');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class)->except('show');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/pdf', [ReportController::class, 'pdf'])->name('reports.pdf');
    Route::get('/reports/excel', [ReportController::class, 'excel'])->name('reports.excel');
});

require __DIR__.'/auth.php';
