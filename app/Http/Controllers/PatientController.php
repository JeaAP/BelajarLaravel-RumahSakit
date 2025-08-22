<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patients;
use App\Models\Doctor;
use App\Models\Rooms;

class PatientController extends Controller
{

    public function index(Request $request)
    {
        $status = $request->input('status');

        $query = Patients::latest();

        if ($status) {
            $query->where('patient_status', $status);
        }

        $patients = $query->paginate(5);

        return view('patients.index', compact('patients'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $doctors = Doctor::select('id', 'name', 'specialization')->get();
        $rooms = Rooms::all();
        return view('patients.create', compact('doctors', 'rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'medical_record_number' => 'required|string|unique:patients',
            'patient_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'patient_address' => 'required|string|max:255',
            'patient_city' => 'required|string|max:255',
            'doctor_id' => 'required|exists:doctors,id',
            'admission_date' => 'required|date',
            'room_number' => 'required|exists:rooms,room_id',
        ]);

        $room = Rooms::where('room_id', $request->room_number)->first();
        if ($room->capacity <= 0) {
            return back()->withErrors(['room_number' => 'Kamar penuh, tidak bisa menambah pasien!']);
        }

        $doctor = Doctor::find($request->doctor_id);

        Patients::create([
            'medical_record_number' => $request->medical_record_number,
            'patient_name' => $request->patient_name,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'patient_address' => $request->patient_address,
            'patient_city' => $request->patient_city,
            'patient_disease' => $doctor->specialization,
            'doctor_id' => $request->doctor_id,
            'admission_date' => $request->admission_date,
            'room_number' => $request->room_number,
            'patient_status' => 'dirawat',
        ]);

        $room->capacity -= 1;
        $room->save();

        return redirect()->route('patients.index')->with('success', 'Data pasien berhasil ditambahkan.');
    }

    public function show(Patients $patient)
    {
        return view('patients.show', compact('patient'));
    }

    public function edit(Patients $patient)
    {
        $doctors = Doctor::all();
        $rooms = Rooms::all();
        return view('patients.edit', compact('patient', 'doctors', 'rooms'));
    }

    public function update(Request $request, Patients $patient)
    {
        $request->validate([
            'patient_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'patient_address' => 'required|string|max:255',
            'patient_city' => 'required|string|max:255',
            'doctor_id' => 'required|exists:doctors,id',
            'admission_date' => 'required|date',
            'discharge_date' => 'nullable|date|after_or_equal:admission_date',
            'room_number' => 'required|exists:rooms,room_id',
            'patient_status' => 'required|in:dirawat,pulang',
        ]);

        $doctor = Doctor::find($request->doctor_id);
        $oldStatus = $patient->patient_status;

        $status = $request->patient_status;
        $dischargeDate = $request->discharge_date;

        if ($status === 'pulang' && !$dischargeDate) {
            $dischargeDate = date('Y-m-d');
        }

        if ($dischargeDate && $dischargeDate == date('Y-m-d')) {
            $status = 'pulang';
        }

        $patient->update([
            'patient_name' => $request->patient_name,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'patient_address' => $request->patient_address,
            'patient_city' => $request->patient_city,
            'patient_disease' => $doctor->specialization,
            'doctor_id' => $request->doctor_id,
            'admission_date' => $request->admission_date,
            'discharge_date' => $dischargeDate,
            'room_number' => $request->room_number,
            'patient_status' => $status,
        ]);

        if ($oldStatus !== 'pulang' && $status === 'pulang') {
            $room = Rooms::where('room_id', $request->room_number)->first();
            if ($room) {
                $room->capacity += 1;
                $room->save();
            }
        }

        return redirect()->route('patients.index')->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function destroy(Patients $patient)
    {
        $patient->delete();
        return redirect()->route('patients.index')->with('success', 'Data pasien berhasil dihapus.');
    }

    public function updateStatus(Patients $patient)
    {
        if ($patient->patient_status !== 'pulang') {
            $dischargeDate = date('Y-m-d');

            $patient->update([
                'patient_status' => 'pulang',
                'discharge_date' => $dischargeDate,
            ]);

            $room = Rooms::where('room_id', $patient->room_number)->first();
            if ($room) {
                $room->capacity += 1;
                $room->save();
            }
        }

        return redirect()->route('patients.index')->with('success', 'Status pasien berhasil diubah menjadi pulang.');
    }

}
