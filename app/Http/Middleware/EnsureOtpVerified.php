<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureOtpVerified
{
    public function handle(Request $request, Closure $next)
    {
        // Kalau belum login via guard lembur, redirect login
        if (!Auth::guard('lembur')->check()) {
            return redirect()->route('login');
        }

        // Kalau masih ada pending_user_id berarti OTP belum diverifikasi
        if (session('pending_user_id')) {
            Auth::guard('lembur')->logout();
            return redirect()->route('otp.index');
        }

        return $next($request);
    }
}
