<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('superadmin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('superadmin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);
        
        $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);
        
        if ($request->has('permissions') && !empty($request->permissions)) {
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            $role->syncPermissions($permissions);
        }
        
        return redirect()->route('superadmin.roles.index')
            ->with('success', "🎖️ Role '{$role->name}' has been created successfully!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        return view('superadmin.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        
        return view('superadmin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);
        
        // Prevent modifying superadmin role
        if ($role->name === 'superadmin' && $request->name !== 'superadmin') {
            return redirect()->route('superadmin.roles.edit', $role)
                ->with('error', "⚠️ The superadmin role name cannot be changed for security reasons!");
        }
        
        $role->name = $request->name;
        $role->save();
        
        if ($request->has('permissions') && !empty($request->permissions)) {
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            $role->syncPermissions($permissions);
        } else {
            $role->syncPermissions([]);
        }
        
        return redirect()->route('superadmin.roles.index')
            ->with('success', "✅ Role '{$role->name}' has been updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        
        // Prevent deleting default roles
        if (in_array($role->name, ['superadmin', 'admin', 'customer'])) {
            return redirect()->route('superadmin.roles.index')
                ->with('error', "⚠️ Default role '{$role->name}' cannot be deleted for system stability!");
        }
        
        $role->delete();
        
        return redirect()->route('superadmin.roles.index')
            ->with('success', "🗑️ Role '{$role->name}' has been deleted successfully!");
    }
}
