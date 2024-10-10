<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = $request->user();

        return response()->json([
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
}
