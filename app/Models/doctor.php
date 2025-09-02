<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class doctor extends Model
{
    protected $table = 'doctors';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'id_number',
        'specialization',
        'practice_location',
        'practice_hours',
        'phone_number',
        'address',
        'city',
        'birth_date',
        'gender',
    ];

    public $timestamps = true;

    protected $unique = [
        'id_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function patients()
    {
        return $this->hasMany(Patients::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    public function examinations()
    {
        return $this->hasMany(Examination::class);
    }
}
