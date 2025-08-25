<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = User::role('admin')->latest()->paginate(10);
        return view('superadmin.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superadmin.admins.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        // Assign admin role
        $user->assignRole('admin');

        return redirect()->route('superadmin.admins.index')
            ->with('success', "👥 Admin user '{$user->name}' has been created successfully!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $admin = User::findOrFail($id);
        return view('superadmin.admins.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $admin = User::findOrFail($id);
        return view('superadmin.admins.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $admin = User::findOrFail($id);
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $admin->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);
        
        $admin->name = $request->name;
        $admin->email = $request->email;
        
        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }
        
        $admin->save();
        
        return redirect()->route('superadmin.admins.index')
            ->with('success', "✅ Admin user '{$admin->name}' has been updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $admin = User::findOrFail($id);
        
        // Prevent deleting yourself
        if ($admin->id === auth()->user()->id) {
            return redirect()->route('superadmin.admins.index')
                ->with('error', "⚠️ You cannot delete your own account!");
        }
        
        $admin->delete();
        
        return redirect()->route('superadmin.admins.index')
            ->with('success', "🗑️ Admin user '{$admin->name}' has been deleted successfully!");
    }
}
