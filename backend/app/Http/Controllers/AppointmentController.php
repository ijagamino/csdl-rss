<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentController extends Controller
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

        $appointments = $user->can('view all reports')
        ? Appointment::query()
            ->where(fn ($query) => $query
                ->where('date', '>', $dateToday)
                ->orWhere(fn ($query) => $query
                    ->where('date', '=', $dateToday)
                    ->where('start_time', '>=', $timeNow)))
            ->where('status', 'approved')
            ->paginate(6)
        : $user->reportAppointments()
            ->where('status', 'approved')
            ->where(fn ($query) => $query
                ->where('date', '>', $dateToday)
                ->orWhere(fn ($query) => $query
                    ->where('date', '=', $dateToday)
                    ->where('start_time', '>=', $timeNow)))
            ->paginate(6);

        // $appointments = $user->reportAppointments()->with('report:id,category,title')->get();

        return response()->json([
            'appointments' => $appointments,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'date' => ['required'],
            'time' => ['required'],
            'report_id' => ['required'],
        ]);

        $time = $attributes['time']['label'];

        [$startTime, $endTime] = explode(' - ', $time);

        $format = 'H:i';
        $formattedStartTime = Carbon::parse($startTime)->format($format);
        $formattedEndTime = Carbon::parse($endTime)->format($format);

        Appointment::create([
            'date' => $attributes['date'],
            'start_time' => $formattedStartTime,
            'end_time' => $formattedEndTime,
            'report_id' => $attributes['report_id'],
        ]);

        return response()->noContent();
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {

        $appointment->status = $request->status;
        $appointment->save();

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}
