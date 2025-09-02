<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Patients;
use App\Models\PatientsDetails;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patients::with(['user', 'doctor', 'patientDetail'])->get();
        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        $doctors = Doctor::with('user')->get();
        return view('patients.create', compact('doctors'));
    }

    public function store(Request $request)
    {
        $userData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $patientData = $request->validate([
            'doctor_id' => 'nullable|exists:doctors,id',
            'medical_record_number' => 'required|string|unique:patients',
            'patient_disease' => 'required|string|max:255',
        ]);

        $patientDetailData = $request->validate([
            'emergency_contact' => 'nullable|string|max:255',
            'insurance_info' => 'nullable|string|max:255',
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
                'role' => 'user',
            ]);

            $patient = Patients::create(array_merge($patientData, [
                'user_id' => $user->id,
            ]));

            PatientsDetails::create(array_merge($patientDetailData, [
                'patient_id' => $patient->id,
            ]));

            return redirect()->route('patients.index')->with('success', 'Data pasien berhasil ditambahkan.');
        } catch (\Exception $e) {
            if (isset($user)) {
                $user->delete();
            }

            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function show(Patients $patient)
    {
        $patient->load(['user', 'doctor.user', 'patientDetail']);
        return view('patients.show', compact('patient'));
    }

    public function edit(Patients $patient)
    {
        $patient->load(['user', 'doctor', 'patientDetail']);
        $doctors = Doctor::with('user')->get();
        return view('patients.edit', compact('patient', 'doctors'));
    }

    public function update(Request $request, Patients $patient)
    {
        $userValidationRules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $patient->user_id,
        ];

        if ($request->filled('password')) {
            $userValidationRules['password'] = 'min:8|confirmed';
        }

        $userData = $request->validate($userValidationRules);

        $patientData = $request->validate([
            'doctor_id' => 'nullable|exists:doctors,id',
            'medical_record_number' => 'required|string|unique:patients,medical_record_number,' . $patient->id,
            'patient_disease' => 'required|string|max:255',
        ]);

        $patientDetailData = $request->validate([
            'emergency_contact' => 'nullable|string|max:255',
            'insurance_info' => 'nullable|string|max:255',
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

            $patient->user->update($userUpdateData);

            $patient->update($patientData);

            if ($patient->patientDetail) {
                $patient->patientDetail->update($patientDetailData);
            } else {
                PatientsDetails::create(array_merge($patientDetailData, [
                    'patient_id' => $patient->id,
                ]));
            }

            return redirect()->route('patients.index')->with('success', 'Data pasien berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function destroy(Patients $patient)
    {
        try {
            if ($patient->user) {
                $patient->user->delete();
            }

            $patient->delete();

            return redirect()->route('patients.index')->with('success', 'Data pasien berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}
