<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $today = Carbon::now();
        $dateToday = Carbon::parse($today)->format('Y-m-d');
        $timeNow = Carbon::parse($today)->format('H:i:s');

        $reports = $user->can('view all reports')
        ? Report::query()
            ->with('appointment', fn ($query) => $query
                ->latest()
                ->where('status', '!=', 'cancelled')
            )
            ->whereHas('appointment', fn ($query) => $query
                ->where(fn ($query) => $query
                    ->where('date', '>', $dateToday)
                    ->orWhere(fn ($query) => $query
                        ->where('date', '=', $dateToday)
                        ->where('start_time', '>=', $timeNow)
                    ))
                ->where('status', '!=', 'completed'))
            ->when($request->status, fn ($query, $status) => $query
                ->whereHas('appointment', fn ($query) => $query
                    ->where('status', $status)))
            ->paginate(6)
        : Report::query()
            ->whereBelongsTo($user)
            ->with('appointment', fn ($query) => $query
                ->latest()
                ->where('status', '!=', 'cancelled')
            )
            ->whereHas('appointment', fn ($query) => $query
                ->where(fn ($query) => $query
                    ->where('date', '>', $dateToday)
                    ->orWhere(fn ($query) => $query
                        ->where('date', '=', $dateToday)
                        ->where('start_time', '>=', $timeNow)
                    ))
                ->where('status', '!=', 'completed'))
            ->when($request->status, fn ($query, $status) => $query
                ->whereHas('appointment', fn ($query) => $query
                    ->where('status', $status)))
            ->paginate(6);

        return response()->json([
            'reports' => $reports,
            'can' => [
                'viewAllReports' => $user->can('view all reports'),
                'viewOwnReports' => $user->can('view own reports'),
                'createReports' => $user->can('create reports'),
                'updateReports' => $user->can('update reports'),
                'updateAppointments' => $user->can('update appointments'),
                'approveAppointments' => $user->can('approve appointments'),
                'cancelAppointments' => $user->can('cancel appointments'),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'category' => ['required'],
            'title' => ['required', 'alpha', 'min:3'],
            'content' => ['required'],
            'date' => ['required'],
            'time' => ['required'],
        ]);

        $time = $attributes['time']['label'];

        [$startTime, $endTime] = explode(' - ', $time);

        $format = 'H:i';
        $formattedStartTime = Carbon::parse($startTime)->format($format);
        $formattedEndTime = Carbon::parse($endTime)->format($format);

        $report = Report::create([
            'user_id' => $request->user()->id,
            'category' => $attributes['category'],
            'title' => $attributes['title'],
            'content' => $attributes['content'],
        ]);

        Appointment::create([
            'date' => $attributes['date'],
            'start_time' => $formattedStartTime,
            'end_time' => $formattedEndTime,
            'report_id' => $report->id,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        return $report->load('appointment');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        //
    }
}
