<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
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

        return response('Dashboard/Index', [
            'reports' => $reports,
            'filters' => $request->only('status'),
        ]);
    }
}
