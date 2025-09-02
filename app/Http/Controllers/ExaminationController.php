<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Examination;
use App\Models\Visit;
use App\Models\Doctor;
use App\Models\Rooms;
use App\Models\diseaserecord;
use App\Models\patients;
use Illuminate\Support\Facades\Auth;

class ExaminationController extends Controller
{
    public function index()
    {
        $doctor = Doctor::where('user_id', auth()->id())->first();

        if (!$doctor) {
            return redirect()->route('doctor')->with('error', 'Data dokter tidak ditemukan.');
        }

        $examinations = Examination::with(['visit.patient.user', 'doctor.user', 'room'])
            ->where('doctor_id', $doctor->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('examinations.index', compact('examinations'));
    }

    public function create(Visit $visit)
    {
        $doctors = Doctor::where('user_id', auth()->id())->get();
        $rooms = Rooms::where('status', 'available')->get();

        return view('examinations.create', compact('visit', 'doctors', 'rooms'));
    }

    public function store(Request $request, Visit $visit)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'room_id' => 'nullable|required_if:needs_hospitalization,1|exists:rooms,id',
            'diagnosis' => 'required|string',
            'treatment_plan' => 'required|string',
            'medications' => 'nullable|string',
            'dosage' => 'nullable|string',
            'needs_hospitalization' => 'boolean',
            'admission_date' => 'nullable|required_if:needs_hospitalization,1|date',
            'discharge_date' => 'nullable|date|after_or_equal:admission_date',
            'patient_status' => 'required|in:under_treatment,recovered,referred',
            'notes' => 'nullable|string',
            'action' => 'required|in:complete,cancel',
            'cancellation_reason' => 'nullable|required_if:action,cancel|string',
            'disease_name' => 'required|string|max:255',
            'symptoms' => 'nullable|string',
            'diagnosis_date' => 'required|date',
            'disease_status' => 'required|in:active,treated,chronic,cured'
        ]);

        if ($request->action === 'cancel') {
            $visit->update([
                'status' => 'cancelled',
                'cancellation_reason' => $request->cancellation_reason,
            ]);

            return redirect()->route('doctor')->with('warning', 'Kunjungan dibatalkan.');
        }

        $examination = Examination::create([
            'visit_id' => $visit->id,
            'doctor_id' => $request->doctor_id,
            'room_id' => $request->room_id,
            'diagnosis' => $request->diagnosis,
            'treatment_plan' => $request->treatment_plan,
            'medications' => $request->medications,
            'dosage' => $request->dosage,
            'needs_hospitalization' => $request->needs_hospitalization ?? false,
            'admission_date' => $request->admission_date,
            'discharge_date' => $request->discharge_date,
            'patient_status' => $request->patient_status,
            'notes' => $request->notes,
        ]);

        diseaserecord::create([
            'patient_id' => $visit->patient_id,
            'disease_name' => $request->disease_name,
            'symptoms' => $request->symptoms,
            'diagnosis_date' => $request->diagnosis_date,
            'status' => $request->disease_status,
            'treatment' => $request->treatment_plan,
        ]);

        $visit->update([
            'status' => 'completed',
        ]);

        if ($request->needs_hospitalization && $request->room_id) {
            $room = Rooms::findOrFail($request->room_id);
            $currentOccupancy = $room->examinations()->where('needs_hospitalization', true)->count();
            if ($currentOccupancy >= $room->capacity) {
                return back()->withErrors(['room_id' => 'Ruangan sudah penuh.'])->withInput();
            }

            if ($currentOccupancy + 1 == $room->capacity) {
                $room->update(['status' => 'occupied']);
            }
        }

        return redirect()->route('examinations.show', $examination)->with('success', 'Hasil pemeriksaan berhasil disimpan.');
    }

    public function show(Examination $examination)
    {
        $doctor = Doctor::where('user_id', auth()->id())->first();

        if ($examination->doctor_id !== $doctor->id) {
            return redirect()->route('examinations.index')->with('error', 'Anda tidak memiliki akses ke pemeriksaan ini.');
        }

        $examination->load(['visit.patient.user', 'doctor.user', 'room']);
        $diseaseRecord = diseaserecord::where('patient_id', $examination->visit->patient_id)
            ->first();

        return view('examinations.show', compact('examination', 'diseaseRecord'));
    }

    public function edit(Examination $examination)
    {
        $doctor = Doctor::where('user_id', auth()->id())->first();

        if ($examination->doctor_id !== $doctor->id) {
            return redirect()->route('examinations.index')->with('error', 'Anda tidak memiliki akses ke pemeriksaan ini.');
        }

        $doctors = Doctor::all();
        $rooms = Rooms::where('status', 'available')->orWhere('id', $examination->room_id)->get();
        $diseaseRecord = diseaserecord::where('patient_id', $examination->visit->patient_id)
            ->first();

        return view('examinations.edit', compact('examination', 'doctors', 'rooms', 'diseaseRecord'));
    }

    public function update(Request $request, Examination $examination)
    {
        $doctor = Doctor::where('user_id', auth()->id())->first();

        if ($examination->doctor_id !== $doctor->id) {
            return redirect()->route('examinations.index')->with('error', 'Anda tidak memiliki akses ke pemeriksaan ini.');
        }

        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'room_id' => 'nullable|exists:rooms,id',
            'diagnosis' => 'required|string',
            'treatment_plan' => 'required|string',
            'medications' => 'nullable|string',
            'dosage' => 'nullable|string',
            'needs_hospitalization' => 'boolean',
            'admission_date' => 'nullable|date',
            'discharge_date' => 'nullable|date|after_or_equal:admission_date',
            'patient_status' => 'required|in:under_treatment,recovered,referred',
            'notes' => 'nullable|string',
            'disease_name' => 'required|string|max:255',
            'symptoms' => 'nullable|string',
            'diagnosis_date' => 'required|date',
            'disease_status' => 'required|in:active,treated,chronic,cured'
        ]);

        $examination->update([
            'doctor_id' => $request->doctor_id,
            'room_id' => $request->patient_status === 'recovered' ? null : $request->room_id,
            'diagnosis' => $request->diagnosis,
            'treatment_plan' => $request->treatment_plan,
            'medications' => $request->medications,
            'dosage' => $request->dosage,
            'needs_hospitalization' => $request->needs_hospitalization ?? false,
            'admission_date' => $request->admission_date,
            'discharge_date' => $request->discharge_date,
            'patient_status' => $request->patient_status,
            'notes' => $request->notes,
        ]);

        $diseaseRecord = diseaserecord::where('patient_id', $examination->visit->patient_id)
            ->first();

        if ($diseaseRecord) {
            $diseaseRecord->update([
                'disease_name' => $request->disease_name,
                'symptoms' => $request->symptoms,
                'diagnosis_date' => $request->diagnosis_date,
                'status' => $request->disease_status,
                'treatment' => $request->treatment_plan,
                'disease_status' => $request->disease_status,
            ]);
        }

        if ($request->needs_hospitalization && $request->room_id) {
            if ($examination->room_id && $examination->room_id != $request->room_id) {
                Rooms::where('id', $examination->room_id)->update(['status' => 'available']);
            }
            Rooms::where('id', $request->room_id)->update(['status' => 'occupied']);
        } elseif ($examination->room_id) {
            Rooms::where('id', $examination->room_id)->update(['status' => 'available']);
        }

        return redirect()->route('examinations.show', $examination)->with('success', 'Data pemeriksaan berhasil diperbarui.');
    }

    public function destroy(Examination $examination)
    {
        $doctor = Doctor::where('user_id', auth()->id())->first();

        if ($examination->doctor_id !== $doctor->id) {
            return redirect()->route('examinations.index')->with('error', 'Anda tidak memiliki akses ke pemeriksaan ini.');
        }

        if ($examination->room_id) {
            Rooms::where('id', $examination->room_id)->update(['status' => 'available']);
        }

        diseaserecord::where('patient_id', $examination->visit->patient_id)
            ->delete();

        $examination->delete();
        return redirect()->route('examinations.index')->with('success', 'Data pemeriksaan berhasil dihapus.');
    }
}