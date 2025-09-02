<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Patients;
use App\Models\PatientsDetails;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        if ($user->role == 'user') {
            $patient = Patients::where('user_id', $user->id)->first();
            if ($patient) {
                $patientDetails = PatientsDetails::where('patient_id', $patient->id)->first();
            }
        }

        return view('profile.edit', compact('user', 'patientDetails'));
    }

    public function update(Request $request, $id = null)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'phone_number' => 'nullable|string|max:15',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'emergency_contact' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'insurance_info' => 'nullable|string|max:100',
        ]);

        $userData = ['name' => $request->name];

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture && file_exists(public_path('images/' . $user->profile_picture))) {
                unlink(public_path('images/' . $user->profile_picture));
            }

            $imageName = time() . '.' . $request->profile_picture->extension();
            $request->profile_picture->move(public_path('images'), $imageName);
            $userData['profile_picture'] = $imageName;
        }

        $user->update($userData);

        if ($user->role == 'user') {
            $patient = Patients::where('user_id', $user->id)->first();

            if (!$patient) {
                $patient = Patients::create(['user_id' => $user->id]);
            }

            $patientDetailsData = [
                'phone_number' => $request->phone_number,
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'emergency_contact' => $request->emergency_contact,
                'address' => $request->address,
                'city' => $request->city,
                'insurance_info' => $request->insurance_info,
            ];

            $patientDetails = PatientsDetails::where('patient_id', $patient->id)->first();

            if ($patientDetails) {
                $patientDetails->update($patientDetailsData);
            } else {
                $patientDetailsData['patient_id'] = $patient->id;
                PatientsDetails::create($patientDetailsData);
            }
        }

        return redirect()->route('profile.show', $patientDetails->id)->with('success', 'Profil berhasil diperbarui.');
    }

    public function show()
    {
        $user = Auth::user();
        $patient = Patients::where('user_id', $user->id)->first();
        $patientDetails = null;

        if ($patient) {
            $patientDetails = PatientsDetails::where('patient_id', $patient->id)->first();
        }

        return view('profile.show', compact('user', 'patient', 'patientDetails'));
    }
}