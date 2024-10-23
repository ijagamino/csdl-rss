<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Label84\HoursHelper\Facades\HoursHelper;

class TimeSlotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $startTime = '09:00';
        $endTime = '17:00';
        $interval = 60;

        $time = HoursHelper::create($startTime, $endTime, $interval, 'g:i A');

        $timeSlots = [];

        for ($i = 0; $i < count($time) - 1; $i++) {
            $startTime = Carbon::parse($time[$i])->format('g:i A');
            $endTime = Carbon::parse($time[$i + 1])->format('g:i A');
            $timeSlots[] = "{$startTime} - {$endTime}";
        }

        return $timeSlots;
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
