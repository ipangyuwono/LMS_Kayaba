<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Otp;
use App\Models\Hp;
use App\Models\CtUsers;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class Login extends Controller
{
    public function index()
    {
        if (Auth::guard('lembur')->check()) {
            return redirect()->route('dashboard')->with('error', 'NPK atau password salah');
        }

        return view('auth.login');
    }

    public function dashboardshow(Request $request)
    {
        Log::info('Login attempt', $request->all());

        $validator = Validator::make($request->all(), [
            'captcha' => 'required|captcha'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('npk', 'password');

        // Coba login dengan guard 'lembur'
        if (!Auth::guard('lembur')->attempt($credentials)) {
            $user = CtUsers::where('npk', $request->npk)->first();

            if (!$user) {
                return back()
                    ->withErrors(['npk' => 'NPK tidak terdaftar atau NPK salah'])
                    ->withInput($request->only('npk'));
            }

            return back()
                ->withErrors(['password' => 'Password tidak sesuai'])
                ->withInput($request->only('npk'));
        }

        $user = Auth::guard('lembur')->user();

        Auth::guard('lembur')->logout();

        $hpRecord = Hp::where('npk', $user->npk)->first();

        if (!$hpRecord) {
            return redirect()->route('login')->with('error', 'NPK tidak memiliki nomor HP terdaftar');
        }

        Otp::where('id_user', $user->id)
            ->where('use', '0')
            ->delete();

        // Buat OTP baru (untuk testing pakai 123456, nanti ganti random)
        $otpCode = 123456;

        $otp = Otp::create([
            'id_user'     => $user->id,
            'otp'         => $otpCode,
            'expiry_date' => now()->addMinutes(5),
            'send'        => '0',
            'send_date'   => null,
            'use'         => '0',
            'use_date'    => null,
        ]);

        // Simpan data penting ke session
        session([
            'pending_user_id' => $user->id,
            'otp_id'          => $otp->id,          
            'auth_guard'      => 'lembur',
            'otp_attempts'    => 0,                     // Reset jumlah percobaan
        ]);

        session()->save();

        Log::info('OTP created and session set', [
            'user_id'    => $user->id,
            'otp_id'     => $otp->id,
            'otp_code'   => $otpCode,                   // Log kode OTP untuk debug (hapus di production)
            'expiry'     => $otp->expiry_date,
        ]);

        // Redirect ke halaman OTP
        return redirect()->route('otp.index');
    }

    public function showOtpForm()
    {
        if (!session('pending_user_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        Log::info('Showing OTP form', [
            'session_id' => session()->getId(),
            'pending_user_id' => session('pending_user_id')
        ]);

        return view('otp');
    }

    public function verifyOtp(Request $request)
    {
        Log::info('OTP Verification attempt', [
            'session_id'              => session()->getId(),
            'request_all'             => $request->all(),
            'pending_user_id'         => session('pending_user_id'),
            'otp_id_from_session'     => session('otp_id'),
            'all_session_keys'        => array_keys(session()->all()),
            'otp_attempts'            => session('otp_attempts', 'not set'),
        ]);


        $otpDigits = $request->input('otp', []);
        $inputOtp = implode('', array_filter($otpDigits));

        if (strlen($inputOtp) !== 6 || !ctype_digit($inputOtp)) {
            return back()->with('error', 'Masukkan kode OTP 6 digit angka yang valid');
        }

        $userId = session('pending_user_id');
        $otpId  = session('otp_id');

        if (!$userId || !$otpId) {
            return redirect()->route('login')->with('error', 'Sesi telah berakhir. Silakan login ulang.');
        }

        $otp = Otp::where('id', $otpId)
            ->where('id_user', $userId)
            ->where('otp', $inputOtp)
            ->where('use', '0')
            ->where('expiry_date', '>', now())
            ->first();

        if (!$otp) {
            $attempts = session('otp_attempts', 0) + 1;
            session(['otp_attempts' => $attempts]);

            Log::warning('OTP verification failed', [
                'input_otp' => $inputOtp,
                'stored_otp' => Otp::find($otpId)?->otp ?? 'not found',
                'attempts' => $attempts,
            ]);

            if ($attempts >= 3) {
                session()->forget(['pending_user_id', 'otp', 'otp_attempts', 'auth_guard']);
                return redirect()->route('login')->with('error', 'Terlalu banyak percobaan. Silakan login ulang.');
            }

            return back()->with('error', 'Kode OTP tidak valid, salah, atau telah kadaluarsa');
        }

        // Sukses
        $otp->update([
            'use'      => '1',
            'use_date' => now(),
        ]);

        $guard = session('auth_guard', 'lembur');

        $user = ($guard === 'lembur') ? CtUsers::find($userId) : User::find($userId);

        if (!$user) {
            return redirect()->route('login')->with('error', 'User tidak ditemukan');
        }

        Auth::guard($guard)->login($user);
        $request->session()->regenerate();

        session()->forget(['pending_user_id', 'otp', 'otp_attempts', 'auth_guard']);

        Log::info('OTP verified successfully', ['user_id' => $userId]);

        return redirect()->intended('/dashboard');
    }

    public function resendOtp()
    {
        $userId = session('pending_user_id');

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Sesi telah berakhir. Silakan login ulang.');
        }

        Otp::where('id_user', $userId)
            ->where('use', '0')
            ->delete();

        $otpCode = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT); // ← gunakan ini di production

        $otp = Otp::create([
            'id_user'     => $userId,
            'otp'         => $otpCode,
            'expiry_date' => now()->addMinutes(5),
            'send'        => '0',
            'send_date'   => null,
            'use'         => '0',
            'use_date'    => null,
        ]);

        session(['otp_id' => $otp->id]);
        session()->save();

        Log::info('OTP resent', [
            'user_id'    => $userId,
            'new_otp_id' => $otp->id,
            'otp_code'   => $otpCode, // hapus di production
        ]);

        // Kembali ke halaman OTP dengan pesan sukses
        return back()->with('success', 'Kode OTP baru telah dikirim. Silakan cek ponsel Anda.');
    }

    public function logout(Request $request)
    {
        $userId = Auth::id();

        Auth::logout();

        if (config('session.driver') === 'database' && $userId) {
            DB::table('sessions')
                ->where('user_id', $userId)
                ->delete();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
