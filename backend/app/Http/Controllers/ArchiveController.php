<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Inertia\Inertia;

class ArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Archives/Index', [
            'reports' => Report::query()->where('status', 'completed')->get(['id', 'category', 'title', 'content', 'status']),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        return Inertia::render('Archives/Show', [
            'report' => $report->only('id', 'category', 'title', 'content', 'status'),
        ]);
    }
}
