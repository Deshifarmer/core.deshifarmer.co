<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'check_in',
        'check_out',
        'cin_location',
        'cout_location',
        'cin_note',
        'cout_note',

    ];
}
