<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return redirect('/');
    }

    public function create()
    {
        return view('profile.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time().'.'.$request->profile_picture->extension();

        $request->profile_picture->move(public_path('images'), $imageName);

        auth()->user()->update(['profile_picture' => $imageName]);

        return redirect()->route('profile.index')->with('success', 'Profil berhasil dibuat.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time().'.'.$request->profile_picture->extension();

        $request->profile_picture->move(public_path('images'), $imageName);

        auth()->user()->update(['profile_picture' => $imageName]);

        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui.');
    }
}

