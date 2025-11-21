<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Inertia\Inertia;

use App\Models\User;

class UserController extends Controller
{
    
    public function index()
    {
        $users = User::orderBy('name')->get();
        return Inertia::render('users/Index', [
            'users' => $users,
        ]);
    }

    public function create()
    {
        return Inertia::render('users/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return to_route('users.index');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return Inertia::render('users/Show', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        return to_route('users.index');
    }

    public function destroy(Request $request, $id)
    {

        $user = User::findOrFail($id);
        $validated = $request->validate([
            'email' => 'required|string|in:' . $user->email,
        ], [
            'email.in' => 'The email you entered does not match.',
        ]);

        if ($validated) {
            $user->delete();
            return to_route('users.index');
        }
        
    }

}
