<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Inertia\Inertia;

use App\Models\User;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    
    public function index()
    {
        $roles = Role::orderBy('name')->get();
        return Inertia::render('roles/Index', [
            'roles' => $roles,
        ]);
    }

    public function create()
    {
        $permissions = Permission::all();
        return Inertia::render('roles/Create', [
            'permissions' => $permissions,
        ]);
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles'
        ]);

        $role = Role::firstOrCreate(['name' => $validated['name']]);

        foreach ($request->input('permissions', []) as $permissionId) {
            if($permissionId === NULL) {
                continue;
            }

            $permission = Permission::findById($permissionId);
            if ($permission) {
                $role->givePermissionTo($permission);
            }
        }

        return to_route('roles.index');
        
    }

    public function show($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $permissions = Permission::all();
        return Inertia::render('roles/Show', [
            'role' => $role,
            'permissions' => $permissions,
        ]);
    }

    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
        ]);

        $role = Role::findOrFail($id);
        $role->update([
            'name' => $validated['name'],
        ]);

        $role->syncPermissions([]);

        foreach ($request->input('permissions', []) as $permissionId) {
            if($permissionId === NULL) {
                continue;
            }

            $permission = Permission::findById($permissionId);
            if ($permission) {
                $role->givePermissionTo($permission);
            }
        }

        return to_route('roles.index');
    }

    public function destroy(Request $request, $id)
    {

        $role = Role::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|in:' . $role->name,
        ], [
            'name.in' => 'The name you entered does not match.',
        ]);

        if ($validated) {
            $role->delete();
            return to_route('roles.index');
        }
        
    }

}
