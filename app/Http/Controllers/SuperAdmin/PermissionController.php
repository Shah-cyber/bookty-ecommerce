<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::all();
        return view('superadmin.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superadmin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
        ]);
        
        Permission::create(['name' => $request->name, 'guard_name' => 'web']);
        
        return redirect()->route('superadmin.permissions.index')
            ->with('success', "🔐 Permission '{$request->name}' has been created successfully!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $permission = Permission::findOrFail($id);
        return view('superadmin.permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $permission = Permission::findOrFail($id);
        return view('superadmin.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $permission = Permission::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
        ]);
        
        $permission->name = $request->name;
        $permission->save();
        
        return redirect()->route('superadmin.permissions.index')
            ->with('success', "✅ Permission '{$permission->name}' has been updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Permission::findOrFail($id);
        
        // Check if permission is in use
        if ($permission->roles()->count() > 0) {
            return redirect()->route('superadmin.permissions.index')
                ->with('error', "⚠️ Permission '{$permission->name}' cannot be deleted because it is used by {$permission->roles()->count()} role(s).");
        }
        
        $permission->delete();
        
        return redirect()->route('superadmin.permissions.index')
            ->with('success', "🗑️ Permission '{$permission->name}' has been deleted successfully!");
    }
}
