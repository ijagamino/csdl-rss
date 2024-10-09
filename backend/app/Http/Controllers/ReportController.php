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

        $reports = $user->can('viewAny', Report::class)
            ? Report::query()
                ->where('status', '!=', 'completed')
                ->with('appointment:report_id,date,start_time,end_time')
                ->get()
            : Report::query()
                ->whereBelongsTo($user)
                ->where('status', '!=', 'completed')
                ->when($request->status, fn ($query, $status) => $query->where('status', $status))
                ->with('appointment:report_id,date,start_time,end_time')
                ->get();

        return $reports;
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
        $report = $report->load('appointment');

        return $report;
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
