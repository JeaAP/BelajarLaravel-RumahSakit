<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Doctor;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with('user')->get();
        return view('doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('doctors.create');
    }

    public function store(Request $request)
    {
        $userData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $doctorData = $request->validate([
            'id_number' => 'required|string|unique:doctors',
            'specialization' => 'required|string|max:255',
            'practice_location' => 'nullable|string|max:255',
            'practice_hours' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
        ]);

        try {
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make($userData['password']),
            ]);

            $doctor = Doctor::create(array_merge($doctorData, [
                'user_id' => $user->id
            ]));

            return redirect()->route('doctors.index')->with('success', 'Data dokter berhasil ditambahkan.');
        } catch (\Exception $e) {
            if (isset($user)) {
                $user->delete();
            }

            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function show(Doctor $doctor)
    {
        $doctor->load('user');
        return view('doctors.show', compact('doctor'));
    }

    public function edit(Doctor $doctor)
    {
        $doctor->load('user');
        return view('doctors.edit', compact('doctor'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $userValidationRules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $doctor->user_id,
        ];

        if ($request->filled('password')) {
            $userValidationRules['password'] = 'min:8|confirmed';
        }

        $userData = $request->validate($userValidationRules);

        $doctorData = $request->validate([
            'id_number' => 'required|string|unique:doctors,id_number,' . $doctor->id,
            'specialization' => 'required|string|max:255',
            'practice_location' => 'nullable|string|max:255',
            'practice_hours' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
        ]);

        try {
            $userUpdateData = [
                'name' => $userData['name'],
                'email' => $userData['email'],
            ];

            if ($request->filled('password')) {
                $userUpdateData['password'] = Hash::make($userData['password']);
            }

            $doctor->user->update($userUpdateData);

            $doctor->update($doctorData);

            return redirect()->route('doctors.index')->with('success', 'Data dokter berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function destroy(Doctor $doctor)
    {
        try {
            if ($doctor->user) {
                $doctor->user->delete();
            }

            $doctor->delete();

            return redirect()->route('doctors.index')->with('success', 'Data dokter berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}
