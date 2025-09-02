<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patients extends Model
{
    protected $table = 'patients';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'medical_record_number',
        'patient_disease',
    ];

    public $timestamps = true;

    // Relasi ke Dokter
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    public function diseaseRecords()
    {
        return $this->hasMany(DiseaseRecord::class);
    }

    public function patientDetail()
    {
        return $this->hasOne(PatientsDetails::class, 'patient_id', 'id');
    }
}

