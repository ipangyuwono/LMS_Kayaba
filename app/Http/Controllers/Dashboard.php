<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Dashboard extends Controller
{
    public function ecashow()
    {
    Log::info('Dashboard accessed', [
        'is_logged_in_lembur' => Auth::guard('lembur')->check(),
        'user_id' => Auth::guard('lembur')->id(),
        'default_guard' => Auth::check(),
    ]);
            return view('dashboard');

    }
}
