<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TakenTimeSlotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $date = $request->input('date');
        $appointments = Appointment::query()
            ->whereDate('date', $date)
            ->whereNotIn('status', ['cancelled', 'completed'])
            ->get();

        $takenTimeSlots = [];

        foreach ($appointments as $appointment) {
            $date = $appointment->date;
            $startTime = Carbon::parse($appointment->start_time)->format('g:i A');
            $endTime = Carbon::parse($appointment->end_time)->format('g:i A');

            $takenTimeSlots[] = "{$startTime} - {$endTime}";
        }

        return $takenTimeSlots;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
