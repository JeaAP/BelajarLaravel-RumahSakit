<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class examination extends Model
{
    protected $table = 'examinations';

    protected $primaryKey = 'id';

    protected $fillable = [
        'visit_id',
        'doctor_id',
        'room_id',
        'diagnosis',
        'treatment_plan',
        'medications',
        'dosage',
        'needs_hospitalization',
        'admission_date',
        'discharge_date',
        'patient_status',
        'notes',
    ];

    protected $casts = [
        'needs_hospitalization' => 'boolean',
        'admission_date' => 'date',
        'discharge_date' => 'date',
    ];

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function room()
    {
        return $this->belongsTo(Rooms::class);
    }
}
