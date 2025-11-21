<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Inertia\Inertia;

use App\Models\User;

use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    
    public function index()
    {
        $users = User::with('roles')->orderBy('name')->get();
        return Inertia::render('users/Index', [
            'users' => $users,
        ]);
    }

    public function create()
    {
        $roles = Role::all();
        return Inertia::render('users/Create', [
            'roles' => $roles,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $role = null;
        if ($request->has('role')) {
            $role = Role::find($request->input('role'))->name;
        } else {
            $role = 'user';
        }

        $user->syncRoles([]);
        $user->assignRole($role);

        return to_route('users.index');
    }

    public function show($id)
    {
        $roles = Role::all();
        $user = User::with('roles')->findOrFail($id);
        return Inertia::render('users/Show', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            // 'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        $role = Role::find($request->input('role'))->name;

        $user->syncRoles([]);
        $user->assignRole($role);

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
