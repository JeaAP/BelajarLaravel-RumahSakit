<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Patients;
use App\Models\Rooms;
use App\Models\DiseaseRecord;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDoctors = Doctor::count();
        $totalPatients = Patients::count();

        $roomData = Rooms::withCount(['examinations'])->get();
        $patientPerRoom = $roomData->map(function ($room) {
            return [
                'room' => $room->room_name,
                'count' => $room->examinations_count
            ];
        });

        $diseaseStats = DiseaseRecord::select('disease_name')
            ->selectRaw('count(*) as total')
            ->groupBy('disease_name')
            ->get();

        $genderStats = Patients::select('gender')
            ->selectRaw('count(*) as total')
            ->groupBy('gender')
            ->get();

        return view('dashboard.index', compact(
            'totalDoctors',
            'totalPatients',
            'patientPerRoom',
            'diseaseStats',
            'genderStats'
        ));
    }
}
