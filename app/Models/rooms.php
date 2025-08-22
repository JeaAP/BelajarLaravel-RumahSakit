<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patients;

class rooms extends Model
{
    protected $fillable = [
        'room_id',
        'room_name',
        'capacity',
        'location',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'capacity' => 'integer',
    ];

    protected function roomName(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => strtoupper($value),
            set: fn ($value) => ucwords($value),
        );
    }

    public function patients()
    {
        return $this->hasMany(Patients::class, 'room_number', 'room_id');
    }
}

