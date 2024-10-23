<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $archives =
        $user->can('view all reports')
        ? Archive::query()
            ->with('report')
            ->with('user')
            ->get()
        : $user->reportArchives()
            ->with('report')
            ->with('user')
            ->get();

        return $archives;
    }

    /**
     * Display the specified resource.
     */
    public function show(Archive $archive)
    {
        $arhive = $archive->only('id', 'category', 'title', 'content', 'status');

        return $archive;
    }
}
