<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Archive;
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
            ->with('report:id,category,title,content')
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
        if ($request->status === 'pending') {
            $attributes = $request->validate([
                'date' => ['required'],
                'time' => ['required'],
            ]);

            $time = $attributes['time']['label'];

            [$startTime, $endTime] = explode(' - ', $time);

            $format = 'H:i';
            $formattedStartTime = Carbon::parse($startTime)->format($format);
            $formattedEndTime = Carbon::parse($endTime)->format($format);

            $appointment->date = $request->date;
            $appointment->start_time = $formattedStartTime;
            $appointment->end_time = $formattedEndTime;
            $appointment->status = 'pending';
        }

        if ($request->status === 'approved') {
            $request->validate([
                'date' => ['required'],
                'start_time' => ['required'],
                'end_time' => ['required'],
                'status' => ['required'],
            ]);

            $appointment->status = $request->status;
        }

        if ($request->status === 'completed') {
            $request->validate([
                'date' => ['required'],
                'start_time' => ['required'],
                'end_time' => ['required'],
                'status' => ['required'],
            ]);

            $appointment->status = $request->status;

            Archive::create([
                'report_id' => $appointment->report_id,
                'user_id' => $request->user()->id,
                'completed' => true,
            ]);
        }

        if ($request->status === 'cancelled') {
            $request->validate([
                'date' => ['prohibited'],
                'start_time' => ['prohibited'],
                'end_time' => ['prohibited'],
                'status' => ['required'],
            ]);

            $appointment->date = null;
            $appointment->start_time = null;
            $appointment->end_time = null;
            $appointment->status = $request->status;
        }
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
