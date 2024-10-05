<?php

use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ScheduleController;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/dashboard', DashboardController::class)->name('dashboard.index');

    Route::controller(ReportController::class)->group(function () {
        Route::get('/reports', 'index')->name('reports.index')->can('view', 'report');
        Route::post('/reports', 'store')->name('reports.store')->can('create', Report::class);
        Route::get('/reports/{report}', 'show')->name('reports.show')->can('view', 'report');
    });

    Route::controller(ContactController::class)->group(function () {
        Route::get('/contacts', 'index')->name('contacts.index');
        Route::post('/contacts', 'store')->name('contacts.store');
        Route::get('/contacts/{contact}', 'show')->name('contacts.show');
    });

    Route::controller(ScheduleController::class)->group(function () {
        Route::get('/schedules', 'index')->name('schedules.index');
        Route::get('/schedules/{report}', 'show')->name('schedules.show');
    });

    Route::controller(ArchiveController::class)->group(function () {
        Route::get('/archives', 'index')->name('archives.index');
        Route::get('/archives/{report}', 'show')->name('archives.show');
    });
});
