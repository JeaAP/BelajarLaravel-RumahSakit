<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Rooms;
use App\Models\Doctor;
use App\Models\Patients;
use App\Models\Visit;
use App\Models\Examination;
use App\Models\DiseaseRecord;
use App\Models\PatientsDetails;

class HomeController extends Controller
{
    public function index()
    {
        $patient = Patients::where('user_id', auth()->user()->id)->first();
        $allDoctors = Doctor::with('user')->get();
        $totalDoctors = Doctor::count();
        $totalPatients = Patients::count();
        $totalRooms = Rooms::count();
        $visits = Visit::selectRaw('*, DATE(requested_date) as requested_date, TIME(requested_time) as requested_time')
            ->where('patient_id', Patients::where('user_id', auth()->user()->id)->value('id'))
            ->orderBy('status', 'asc')
            ->orderBy('requested_date', 'desc')
            ->orderBy('requested_time', 'desc')
            ->get();

        return view('welcome', compact(
            'allDoctors',
            'totalDoctors',
            'totalPatients',
            'totalRooms',
            'visits',
            'patient'
        ));
    }

    public function dashboard()
    {
        $totalDoctors = Doctor::count();
        $totalPatients = Patients::count();
        $totalRooms = Rooms::count();
        $totalVisits = Visit::count();

        $patientsByRoom = Examination::select('rooms.room_name', DB::raw('COUNT(examinations.id) as count'))
            ->join('rooms', 'examinations.room_id', '=', 'rooms.id')
            ->groupBy('examinations.room_id', 'rooms.room_name')
            ->orderBy('count', 'desc')
            ->get();

        $patientsByDisease = DiseaseRecord::select('disease_name', DB::raw('COUNT(*) as count'))
            ->groupBy('disease_name')
            ->orderBy('count', 'desc')
            ->get();

        $patientsByGender = PatientsDetails::selectRaw("gender, COUNT(*) as count, DATE(created_at) as date")
            ->groupBy('gender', 'date')
            ->orderBy('date', 'asc')
            ->get()
            ->groupBy('date')
            ->map(function ($dayData) {
                return [
                    'Laki-laki' => $dayData->where('gender', 'Laki-laki')->sum('count'),
                    'Perempuan' => $dayData->where('gender', 'Perempuan')->sum('count')
                ];
            });

        return view('dashboard', compact(
            'totalDoctors',
            'totalPatients',
            'totalRooms',
            'totalVisits',
            'patientsByRoom',
            'patientsByDisease',
            'patientsByGender'
        ));
    }

    public function doctor()
    {
        $doctorId = Doctor::where('user_id', Auth::id())->value('id');

        $approvedVisits = Visit::with(['patient.user'])
            ->whereHas('patient', function ($query) use ($doctorId) {
                $query->where('doctor_id', $doctorId);
            })
            ->where('status', 'approved')
            ->orderByDesc('requested_date')
            ->orderByDesc('requested_time')
            ->get();

        $doctor = Doctor::with('user')
            ->where('user_id', Auth::id())
            ->first();

        return view('doctor', compact('approvedVisits', 'doctor'));
    }
}