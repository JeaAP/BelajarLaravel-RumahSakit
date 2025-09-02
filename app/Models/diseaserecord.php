<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class diseaserecord extends Model
{
    protected $table = 'disease_records';

    protected $primaryKey = 'id';

    protected $fillable = [
        'patient_id',
        'disease_name',
        'symptoms',
        'diagnosis_date',
        'status',
        'treatment',
    ];

    protected $casts = [
        'diagnosis_date' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patients::class);
    }
}
