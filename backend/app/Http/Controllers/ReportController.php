<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Label84\HoursHelper\Facades\HoursHelper;

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
                ->with('appointment:report_id,date,start_time,end_time')->get()
            : Report::query()
                ->whereBelongsTo($user)
                ->where('status', '!=', 'completed')
                ->when($request->status, fn ($query, $status) => $query->where('status', $status))
                ->with('appointment:report_id,date,start_time,end_time')
                ->get();

        // return response()->toJson();
        // return ('Dashboard/Index', [
        //     'reports' => $reports,
        //     'filters' => $request->only('status'),
        // ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $startTime = '09:00';
        $endTime = '17:00';
        $interval = 60;

        $time = HoursHelper::create($startTime, $endTime, $interval, 'g:i A');

        for ($i = 0; $i < count($time) - 1; $i++) {
            $timeSlots[] = [
                'startTime' => date('g:i A', strtotime($time[$i])),
                'endTime' => date('g:i A', strtotime($time[$i + 1])),
            ];
        }

        $appointments = Appointment::all();

        $unavailableSlots = [];

        foreach ($appointments as $appointment) {
            $date = $appointment->date;
            if (! isset($unavailableSlots[$date])) {
                $unavailableSlots[$date] = ['slots' => []];
            }
            $unavailableSlots[$date]['slots'][] = [
                'startTime' => Carbon::parse($appointment->start_time)->format('g:i A'),
                'endTime' => Carbon::parse($appointment->end_time)->format('g:i A'),
            ];
        }
        $formattedSlots = array_map(function ($timeSlot) {
            return "{$timeSlot['startTime']} - {$timeSlot['endTime']}";
        }, $timeSlots);

        return Inertia::render('Reports/Create', [
            'timeSlots' => $timeSlots,
            'formattedSlots' => $formattedSlots,
            'unavailableSlots' => $unavailableSlots,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'category' => ['required'],
            'title' => ['required'],
            'content' => ['required'],
            'date' => ['required'],
            'time' => ['required'],
        ]);

        $userId = $request->user()->id;

        $time = $attributes['time']['label'];

        [$startTime, $endTime] = explode(' - ', $time);

        $format = 'H:i';
        $formattedStartTime = Carbon::parse($startTime)->format($format);
        $formattedEndTime = Carbon::parse($endTime)->format($format);

        $report = Report::create([
            'user_id' => $userId,
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

        return redirect('/dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        return Inertia::render('Reports/Show', [
            'report' => $report->only('id', 'category', 'title', 'content', 'status'),
            'appointment' => $report->appointment->only('id', 'report_id', 'date', 'start_time', 'end_time'),
        ]);
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
