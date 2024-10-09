<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $archives = $user->reportArchives()
            ->with('report:id,category,title,content,status')
            ->with('user:id,first_name,last_name')
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
