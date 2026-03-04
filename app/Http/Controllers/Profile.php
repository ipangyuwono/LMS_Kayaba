<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Profile extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $user = auth('lembur')->user();

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan, silakan login ulang.');
        }

        $user->full_name = $request->name;
        $user->npk = $request->npk;
        $user->dept = $request->department;
        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}
