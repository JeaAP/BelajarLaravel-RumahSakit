<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visit;
use App\Models\Patients;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;

class VisitController extends Controller
{
    public function index()
    {
        $visits = Visit::with(['patient.user', 'patient'])->get();
        $doctors = Doctor::all();
        return view('visits.index', compact('visits', 'doctors'));
    }

    public function create()
    {
        $patients = Patients::all();
        return view('visits.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required',
            'complaint' => 'required',
            'treatment_request' => 'required',
            'requested_date' => 'required|date',
            'requested_time' => 'required|date_format:H:i',
        ]);

        Visit::create([
            'patient_id' => $request->patient_id,
            'complaint' => $request->complaint,
            'treatment_request' => $request->treatment_request,
            'requested_date' => $request->requested_date,
            'requested_time' => $request->requested_time,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Kunjungan berhasil dibuat.');
    }

    public function show(Visit $visit)
    {
        $visit->load(['patient.user', 'patient.doctor']);
        return view('visits.show', compact('visit'));
    }

    public function edit(Visit $visit)
    {
        $doctors = Doctor::all();
        return view('visits.edit', compact('visit', 'doctors'));
    }

    public function update(Request $request, Visit $visit)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed,cancelled',
            'doctor_id' => 'nullable|exists:doctors,id',
            'cancellation_reason' => 'nullable|string|max:255'
        ]);

        if ($request->status === 'cancelled' && !$request->cancellation_reason) {
            return back()->withErrors(['cancellation_reason' => 'Alasan pembatalan wajib diisi.']);
        }

        $visit->update([
            'status' => $request->status,
            'doctor_id' => $request->doctor_id,
            'cancellation_reason' => $request->cancellation_reason,
        ]);

        return redirect()->route('visits.index')->with('success', 'Data kunjungan berhasil diperbarui.');
    }

    public function destroy(Visit $visit)
    {
        $visit->delete();
        return redirect()->route('visits.index')->with('success', 'Data kunjungan berhasil dihapus.');
    }
}
