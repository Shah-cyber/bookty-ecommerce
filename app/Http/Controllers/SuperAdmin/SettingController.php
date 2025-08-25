<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        // Get all settings grouped by their group
        $settings = Setting::all()->groupBy('group');
        
        return view('superadmin.settings.index', compact('settings'));
    }
    
    public function update(Request $request)
    {
        // Validate the request
        $request->validate([
            'settings' => 'required|array',
            'settings.*' => 'nullable',
        ]);
        
        // Update each setting
        foreach ($request->settings as $key => $value) {
            Setting::setValue($key, $value);
        }
        
        return redirect()->route('superadmin.settings.index')
            ->with('success', '⚙️ System settings have been updated successfully!');
    }
}
