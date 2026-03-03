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
        // Add validation and update logic here
        // For now, redirect back with success message
        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui!');
    }
}
