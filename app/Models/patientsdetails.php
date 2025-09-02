<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class patientsdetails extends Model
{
    use HasFactory;

    protected $table = 'patients_details';

    protected $primaryKey = 'id';

    protected $fillable = [
        'patient_id',
        'emergency_contact',
        'insurance_info',
        'phone_number',
        'address',
        'city',
        'birth_date',
        'gender',
    ];

    public function patient()
    {
        return $this->belongsTo(Patients::class);
    }
}

