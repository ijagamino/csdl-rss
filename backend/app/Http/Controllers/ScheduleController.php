<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $reports = $user->can('viewAny', Report::class)
            ? Report::query()
                ->with('appointment:report_id,date,start_time,end_time')->get()
            : Report::query()
                ->whereBelongsTo($user)
                ->where('status', '!=', 'completed')
                ->when($request->status, fn ($query, $status) => $query->where('status', $status))
                ->with('appointment:report_id,date,start_time,end_time')
                ->get();

        return inertia('Schedules/Index', [
            'reports' => $reports,
            'filters' => $request->only('status'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        //
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
