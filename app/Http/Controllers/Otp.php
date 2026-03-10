<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Otp as OtpModel;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

class Otp extends Controller
{
    public function index()
    {
        return view('otp');
    }

    public function verify(Request $request)
    {
        $otpArray = $request->input('otp', []);
        $inputOtp = implode('', $otpArray);

        $userId = Auth::id();
        $otpRecord = OtpModel::where('id_user', $userId)
            ->where('use', '0') // Hanya cek yang belum dipakai
            ->latest()
            ->first();

        // VALIDASI
        if ($otpRecord && $inputOtp == $otpRecord->otp) {

            if (now()->gt($otpRecord->expiry_date)) {
                return back()->with('error', 'Kode OTP Sudah Kadaluarsa!');
            }

            session(['otp_verified' => true]);

            // Tandai OTP sebagai terpakai
            $otpRecord->update([
                'use' => '1',
                'use_date' => now()
            ]);

            return redirect()->route('dashboard');
        }

        return back()->with('error', 'Kode OTP Salah!');
    }
}
