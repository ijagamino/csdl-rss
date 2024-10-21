<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\TakenTimeSlotController;
use App\Http\Controllers\TimeSlotController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        $user = $request->user();

        $permissions = $user->getAllPermissions()
            ->pluck('name')
            ->mapWithKeys(function ($permission) {
                $camelCasePermission = Str::camel($permission);

                return [$camelCasePermission => true];
            });

        return response()->json([
            'user' => $user,
            'can' => $permissions,
        ]);
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'index')->name('users.index');
        Route::patch('/users/{user}', 'update')->name('users.update');
    });

    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/permissions/{permission}', [PermissionController::class, 'show'])->name('permissions.show');
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/{role:name}', [RoleController::class, 'show'])->name('roles.show');

    Route::get('/dashboard', DashboardController::class)->name('dashboard.index');

    Route::get('/time-slots', [TimeSlotController::class, 'index'])->name('time-slots.index');
    Route::get('/taken-time-slots', [TakenTimeSlotController::class, 'index'])->name('taken-time-slots.index');

    Route::controller(ReportController::class)->group(function () {
        Route::get('/reports', 'index')->name('reports.index');
        Route::post('/reports', 'store')->name('reports.store');
        Route::get('/reports/{report}', 'show')->name('reports.show')->can('view', 'report');
        Route::delete('/reports/{report}', 'destroy')->name('reports.destroy')->can('view', 'report');
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
