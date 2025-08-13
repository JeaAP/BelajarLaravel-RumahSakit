<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class doctor extends Model
{
    protected $table = 'doctors';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_number',
        'name',
        'birth_date',
        'specialization',
        'practice_location',
        'practice_hours',
    ];

    public $timestamps = true;

    protected $unique = [
        'id_number',
    ];
}
