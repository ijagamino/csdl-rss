<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        $user = User::with('roles:name')->get();

        return $user;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request) {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'email' => ['required', 'email'],
            'username' => ['required'],
            // 'password' => ['required', Password::min(6)->letters()->mixedCase()->numbers(), 'confirmed'],
            'password' => ['required', 'confirmed'],
        ]);

        User::create($attributes);

        return redirect()->intended();
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $roles = $request->roles;

        $user->syncRoles($roles);

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
