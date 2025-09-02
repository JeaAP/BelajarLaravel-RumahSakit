<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class visit extends Model
{
    protected $table = 'visits';

    protected $primaryKey = 'id';

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'complaint',
        'treatment_request',
        'requested_date',
        'requested_time',
        'status',
        'cancellation_reason',
    ];

    protected $casts = [
        'requested_date' => 'date',
        'requested_time' => 'datetime:H:i',
    ];

    public function patient()
    {
        return $this->belongsTo(Patients::class, 'patient_id', 'id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'id');
    }

    public function examination()
    {
        return $this->hasOne(Examination::class);
    }
}
