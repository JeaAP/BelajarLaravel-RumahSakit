<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patients extends Model
{
    protected $table = 'patients';
    protected $primaryKey = 'id';

    protected $fillable = [
        'medical_record_number',
        'patient_name',
        'birth_date',
        'gender',
        'patient_address',
        'patient_city',
        'patient_disease',
        'doctor_id',
        'admission_date',
        'discharge_date',
        'room_number',
        'patient_status',
    ];

    public $timestamps = true;

    // Relasi ke Dokter
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    // Relasi ke Room
    public function room()
    {
        return $this->belongsTo(Rooms::class, 'room_number', 'room_id');
    }
}
