<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Show system preference page (theme).
     */
    public function system()
    {
        return view('admin.settings.system');
    }
}


