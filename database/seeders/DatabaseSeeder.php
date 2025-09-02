<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\diseaserecord;
use App\Models\doctor;
use App\Models\examination;
use App\Models\Patients;
use App\Models\patientsdetails;
use App\Models\rooms;
use App\Models\visit;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Operator',
            'email' => 'operator@example.com',
            'password' => Hash::make('password'),
            'role' => 'operator',
        ]);

        User::factory()->create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Data dokter
        $doctors = [
            [
                'name' => 'Dokter',
                'email' => 'dokter@example.com',
                'id_number' => 'DOK001',
                'specialization' => 'Dokter Umum',
                'practice_location' => 'Jl. Raya Ciledug',
                'practice_hours' => '08.00-12.00',
            ],
            [
                'name' => 'Budi',
                'email' => 'budi@example.com',
                'id_number' => 'DOK002',
                'specialization' => 'Poli Gigi',
                'practice_location' => 'Jl. Sudirman No. 10',
                'practice_hours' => '09.00-13.00',
            ],
            [
                'name' => 'Siti',
                'email' => 'siti@example.com',
                'id_number' => 'DOK003',
                'specialization' => 'Poli Anak',
                'practice_location' => 'Jl. Merdeka No. 21',
                'practice_hours' => '10.00-14.00',
            ],
            [
                'name' => 'Andi',
                'email' => 'andi@example.com',
                'id_number' => 'DOK004',
                'specialization' => 'Poli Bedah',
                'practice_location' => 'Jl. Gatot Subroto No. 7',
                'practice_hours' => '13.00-17.00',
            ],
            [
                'name' => 'Lina',
                'email' => 'lina@example.com',
                'id_number' => 'DOK005',
                'specialization' => 'Poli Kulit',
                'practice_location' => 'Jl. Diponegoro No. 5',
                'practice_hours' => '15.00-19.00',
            ],
        ];

        foreach ($doctors as $doc) {
            $user = User::factory()->create([
                'name' => $doc['name'],
                'email' => $doc['email'],
                'password' => Hash::make('password'),
                'role' => 'doctor',
            ]);

            doctor::create([
                'user_id' => $user->id,
                'id_number' => $doc['id_number'],
                'specialization' => $doc['specialization'],
                'practice_location' => $doc['practice_location'],
                'practice_hours' => $doc['practice_hours'],
            ]);
        }

        // Create patients
        Patients::create([
            'user_id' => 2,
            'medical_record_number' => '1234567890',
            'patient_disease' => 'Demam',
        ]);

        patientsdetails::create([
            'patient_id' => 1,
            'emergency_contact' => '081234567890',
            'insurance_info' => 'Jamsostek',
            'phone_number' => '081234567890',
            'address' => 'Jl. Raya Ciledug No. 1',
            'city' => 'Tangerang',
            'birth_date' => '1990-01-01',
            'gender' => 'male',
        ]);

        // Create rooms
        $rooms = [];
        for ($i = 1; $i <= 10; $i++) {
            $rooms[] = [
                'room_id' => "R-{$i}",
                'room_name' => "Kamar {$i}",
                'capacity' => rand(1, 10),
                'location' => "Lantai " . ceil($i / 2),
                'status' => in_array($i, [3, 6, 9]) ? 'maintenance' : 'available',
            ];
        }
        foreach ($rooms as $room) {
            rooms::create($room);
        }

        // Create visits
        visit::create([
            'patient_id' => 1,
            'doctor_id' => null,
            'complaint' => 'Sakit Kepala',
            'treatment_request' => 'Perlu Pemeriksaan',
            'requested_date' => '2022-01-01',
            'requested_time' => '08:00:00',
            'status' => 'pending',
            'cancellation_reason' => null,
        ]);

        // Create disease records
        diseaserecord::create([
            'patient_id' => 1,
            'disease_name' => 'Demam',
            'symptoms' => 'Sakit Kepala, Sakit Badan',
            'diagnosis_date' => '2022-01-01',
            'status' => 'active',
            'treatment' => 'Paracetamol',
        ]);

        // Create examinations
        examination::create([
            'visit_id' => 1,
            'doctor_id' => 1,
            'room_id' => 1,
            'diagnosis' => 'Sakit Kepala',
            'treatment_plan' => 'Perlu Pemeriksaan',
            'medications' => 'Paracetamol',
            'dosage' => '2x1',
            'needs_hospitalization' => false,
            'admission_date' => null,
            'discharge_date' => null,
            'patient_status' => 'under_treatment',
            'notes' => null,
        ]);
    }
}

