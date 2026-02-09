<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view settings')->only(['system']);
    }

    /**
     * Show system preference page (theme).
     */
    public function system()
    {
        return view('admin.settings.system');
    }
}


