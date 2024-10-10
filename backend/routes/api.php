<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\TakenTimeSlotController;
use App\Http\Controllers\TimeSlotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/permissions', PermissionController::class)->name('permissions.index');

    Route::get('/dashboard', DashboardController::class)->name('dashboard.index');

    Route::get('/time-slots', [TimeSlotController::class, 'index'])->name('time-slots.index');
    Route::get('/taken-time-slots', [TakenTimeSlotController::class, 'index'])->name('taken-time-slots.index');

    Route::controller(ReportController::class)->group(function () {
        Route::get('/reports', 'index')->name('reports.index');
        Route::post('/reports', 'store')->name('reports.store');
        Route::get('/reports/{report}', 'show')->name('reports.show')->can('view', 'report');
    });

    Route::controller(AppointmentController::class)->group(function () {
        Route::get('/appointments', 'index')->name('appointments.index');
        Route::get('/appointments/{appointment}', 'show')->name('appointments.show');
        Route::patch('/appointments/{appointment}', 'update')->name('appointments.update');
    });

    Route::controller(ArchiveController::class)->group(function () {
        Route::get('/archives', 'index')->name('archives.index');
        Route::get('/archives/{report}', 'show')->name('archives.show');
    });

    Route::controller(FeedbackController::class)->group(function () {
        Route::get('/feedbacks', 'index')->name('feedbacks.index');
        Route::post('/feedbacks', 'store')->name('feedbacks.store');
        Route::get('/feedbacks/{feedback}', 'show')->name('feedbacks.show');
    });

    Route::controller(ScheduleController::class)->group(function () {
        Route::get('/schedules', 'index')->name('schedules.index');
        Route::get('/schedules/{report}', 'show')->name('schedules.show');
    });
});
